<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Merchant\Owner;
use App\Models\Merchant\Building;
use App\Models\Building\Price;

class BuildingController extends Controller
{

    public function index($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $markets = Market::all();
        $buldings = Building::with('owner', 'market')
                            ->with(['price' => function($query) {
                                $query->with('type');
                            }])->get();
        $owners = Owner::all();
        $prices = Price::with('type')->get();

        $building_number= count($buldings);
        $building_number_plus = $building_number + 1;
        $register_number = date('Y') . '/' . date('d') . '/' ;
        $register_number .= randomString(5) . '/' . $building_number_plus ;

        $data = [
            'path' => 'merchant',
            'subpath' => 'building',
            'markets' => $markets,
            'buildings' => $buldings,
            'owners' => $owners,
            'prices' => $prices,
            'register' =>$register_number
        ];

        return $this->view->render($response, 'merchants/building/index.twig', compact('data'));
    }

    public function show($request, $response, $args)
    {
        // if (!isAdmin($this->auth->user()->role[0]->id))
        //     throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $building = Building::with('owner', 'market')
        ->with(['price' => function($query) {
            $query->with('type');
        }])->where('id', $id)->first();
        return $response->withJson($building, 200);
    }

    public function store($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $parsed_data = (Object)$request->getParsedBody();

        $data = [
            'register_number' => $parsed_data->register_number,
            'name' => $parsed_data->name,
            'description' => $parsed_data->description,
            'widht' => $parsed_data->widht,
            'length' => $parsed_data->length,
            'price_id' => $parsed_data->price_id,
            'market_id' => $parsed_data->market_id,
            'due_day'  =>  date('d', strtotime($parsed_data->due_date . ' 00:00:00')),
            'due_month'  =>  date('m', strtotime($parsed_data->due_date . ' 00:00:00'))
        ];

        $building = Building::create($data);

        if (!$building) {
            $this->flash->addMessage('error', "Failed add new Building!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
        }

        $building = Building::findOrFail($building->id);

        if($building) $building->owner()->attach($parsed_data->owner_id);

        $this->flash->addMessage('info', "Success add new Building with Register Number { $building->register_number }!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.building'));

    }

    public function update($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $parsed_data = (Object)$request->getParsedBody();
        $building = Building::findOrFail($parsed_data->id);

        if (!$building) {
            $this->flash->addMessage('error', "Failed update Building data!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
        }

        $data = [
            'register_number' => $parsed_data->register_number,
            'name' => $parsed_data->name,
            'description' => $parsed_data->description,
            'widht' => $parsed_data->widht,
            'length' => $parsed_data->length,
            'price_id' => $parsed_data->price_id,
            'market_id' => $parsed_data->market_id,
            'due_day'  =>  date('d', strtotime($parsed_data->due_date . ' 00:00:00')),
            'due_month'  =>  date('m', strtotime($parsed_data->due_date . ' 00:00:00'))
        ];

        $update = $building->update($data);
        if (!$update) {
            $this->flash->addMessage('error', "Failed update Building data!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
        }

        $building->owner()->sync($parsed_data->owner_id);

        $this->flash->addMessage('info', "Success update Building data {$parsed_data->name}!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
    }

    public function delete($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $building = Building::findOrFail($id);
        if ($building) {
            $building->delete();
            $this->flash->addMessage('info', "Success delete building {$building->title}!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
        }

        $this->flash->addMessage('error', "Failed delete Building {$owner->title}!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.building'));
    }

}