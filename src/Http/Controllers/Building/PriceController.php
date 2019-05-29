<?php

namespace App\Http\Controllers\Building;

use Respect\Validation\Validator;
use App\Http\Controllers\Controller;

use App\Models\Building\Price;
use App\Models\Building\Type;


class PriceController extends Controller
{

    public function index($request, $response)
    {
        $prices = Price::all();
        $types = Type::all();
        $data = [
            'path' => 'building',
            'subpath' => 'price',
            'prices' => $prices,
            'types' => $types
        ];
        return $this->view->render($response, 'merchants/building_price/index.twig', compact('data'));
    }

    public function show($request, $response, $args)
    {
        $id = $args['id'];
        $price = Price::findOrFail($id);
        return $response->withJson($price, 200);
    }

    public function store($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'title' => Validator::notEmpty(),
            'description' => Validator::notEmpty(),
            'price' => Validator::notEmpty(),
        ]);
        if($validation->failed()) {
            $this->flash->addMessage('error', "Failed add new Building Price!");
            return $response->withRedirect($this->router->pathFor('dash.building.price'));
        }
        $create = Price::create($request->getParsedBody());
        if (!$create) {
            $this->flash->addMessage('error', "Failed add new Building Price!");
            return $response->withRedirect($this->router->pathFor('dash.building.price'));
        }
        $this->flash->addMessage('info', "Success add new Building Price!");
        return $response->withRedirect($this->router->pathFor('dash.building.price'));
    }

    public function update($request, $response)
    {
        $price = price::findOrFail($request->getParsedBody()['id']);
        if (!$price) {
            $this->flash->addMessage('error', "Failed update Building Price!");
            return $response->withRedirect($this->router->pathFor('dash.building.price'));
        }
        $update = $price->update($request->getParsedBody());
        if (!$update) {
            $this->flash->addMessage('error', "Failed update Building Price!");
            return $response->withRedirect($this->router->pathFor('dash.building.price'));
        }
        $this->flash->addMessage('info', "Success update Building Price {$price->title}!");
        return $response->withRedirect($this->router->pathFor('dash.building.price'));
    }

    public function delete($request, $response, $args)
    {
        $id = $args['id'];
        $price = Price::findOrFail($id);
        if ($price) {
            $price->delete();
            $this->flash->addMessage('info', "Success delete Building Price {$price->title}!");
            return $response->withRedirect($this->router->pathFor('dash.building.price'));
        }
        $this->flash->addMessage('error', "Failed delete Building price {$price->title}!");
        return $response->withRedirect($this->router->pathFor('dash.building.price'));
    }

}