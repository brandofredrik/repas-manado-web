<?php

namespace App\Http\Controllers\Building;

use Respect\Validation\Validator;
use App\Http\Controllers\Controller;

use App\Models\Building\Type;

class TypeController extends Controller
{

    public function index($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $types = Type::all();
        $data = [
            'path' => 'building',
            'subpath' => 'type',
            'types' => $types
        ];
        return $this->view->render($response, 'merchants/building_type/index.twig', compact('data'));
    }

    public function show($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $type = Type::findOrFail($id);
        return $response->withJson($type, 200);
    }

    public function store($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $validation = $this->validator->validate($request, [
            'title' => Validator::notEmpty(),
            'description' => Validator::notEmpty(),
        ]);
        if($validation->failed()) {
            $this->flash->addMessage('error', "Failed add new Building Type!");
            return $response->withRedirect($this->router->pathFor('dash.building.type'));
        }
        $create = Type::create($request->getParsedBody());
        if (!$create) {
            $this->flash->addMessage('error', "Failed add new Building Type!");
            return $response->withRedirect($this->router->pathFor('dash.building.type'));
        }
        $this->flash->addMessage('info', "Success add new Building Type!");
        return $response->withRedirect($this->router->pathFor('dash.building.type'));
    }

    public function update($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $type = Type::findOrFail($request->getParsedBody()['id']);
        if (!$type) {
            $this->flash->addMessage('error', "Failed update Building Type!");
            return $response->withRedirect($this->router->pathFor('dash.building.type'));
        }
        $update = $type->update($request->getParsedBody());
        if (!$update) {
            $this->flash->addMessage('error', "Failed update Building Type!");
            return $response->withRedirect($this->router->pathFor('dash.building.type'));
        }
        $this->flash->addMessage('info', "Success update Building Type {$price->title}!");
        return $response->withRedirect($this->router->pathFor('dash.building.type'));
    }

    public function delete($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $type = Type::findOrFail($id);
        if ($type) {
            $type->delete();
            $this->flash->addMessage('info', "Success delete Building Type {$type->title}!");
            return $response->withRedirect($this->router->pathFor('dash.building.type'));
        }
        $this->flash->addMessage('error', "Failed delete Building Type {$type->title}!");
        return $response->withRedirect($this->router->pathFor('dash.building.type'));
    }

}