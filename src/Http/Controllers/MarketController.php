<?php

namespace App\Http\Controllers;

use Respect\Validation\Validator;
use App\Http\Controllers\Controller;

use App\Models\Market;

class MarketController extends Controller
{

    public function index($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $markets = Market::all();
        $data = [
            'path' => 'market',
            'markets' => $markets
        ];
        return $this->view->render($response, 'markets/index.twig', compact('data'));
    }

    public function show($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $market = Market::findOrFail($id);
        return $response->withJson($market, 200);
    }

    public function store($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $validation = $this->validator->validate($request, [
            'title' => Validator::notEmpty(),
            'address' => Validator::notEmpty(),
        ]);

        if($validation->failed()) {
            $this->flash->addMessage('error', "Failed add new Market!");
            return $response->withRedirect($this->router->pathFor('dash.market'));
        }

        $create = Market::create($request->getParsedBody());

        if (!$create) {
            $this->flash->addMessage('error', "Failed add new Market!");
            return $response->withRedirect($this->router->pathFor('dash.market'));
        }

        $this->flash->addMessage('info', "Success add new Market!");
        return $response->withRedirect($this->router->pathFor('dash.market'));
    }

    public function update($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $market = Market::findOrFail($request->getParsedBody()['id']);
        if (!$market) {
            $this->flash->addMessage('error', "Failed update Market!");
            return $response->withRedirect($this->router->pathFor('dash.market'));
        }

        $update = $market->update($request->getParsedBody());
        if (!$update) {
            $this->flash->addMessage('error', "Failed update Market!");
            return $response->withRedirect($this->router->pathFor('dash.market'));
        }

        $this->flash->addMessage('info', "Success update Market {$market->title}!");
        return $response->withRedirect($this->router->pathFor('dash.market'));
    }

    public function delete($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $market = Market::findOrFail($id);
        if ($market) {
            $market->delete();
            $this->flash->addMessage('info', "Success delete Market {$market->title}!");
            return $response->withRedirect($this->router->pathFor('dash.market'));
        }
        $this->flash->addMessage('error', "Failed delete Market {$market->title}!");
        return $response->withRedirect($this->router->pathFor('dash.market'));
    }
}