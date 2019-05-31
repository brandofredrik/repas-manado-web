<?php

namespace App\Http\Controllers\Merchant;

use Respect\Validation\Validator;
use App\Http\Controllers\Controller;

use App\Models\Merchant\Owner;

class OwnerController extends Controller
{

    public function index($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $owners = Owner::all();
        $data = [
            'path' => 'merchant',
            'subpath' => 'owner',
            'owners' => $owners
        ];
        return $this->view->render($response, 'merchants/owner/index.twig', compact('data'));
    }

    public function show($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $owner = Owner::findOrFail($id);
        return $response->withJson($owner, 200);
    }

    public function store($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $validation = $this->validator->validate($request, [
            'name' => Validator::notEmpty(),
            'phone' => Validator::notEmpty(),
        ]);

        if($validation->failed()) {
            $this->flash->addMessage('error', "Failed add new Owner!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
        }

        $create = Owner::create($request->getParsedBody());

        if (!$create) {
            $this->flash->addMessage('error', "Failed add new Owner!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
        }

        $this->flash->addMessage('info', "Success add new Owner!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
    }

    public function update($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $owner = Owner::findOrFail($request->getParsedBody()['id']);
        if (!$owner) {
            $this->flash->addMessage('error', "Failed update Owner!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
        }

        $update = $owner->update($request->getParsedBody());
        if (!$update) {
            $this->flash->addMessage('error', "Failed update Owner!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
        }

        $this->flash->addMessage('info', "Success update Owner {$owner->title}!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
    }

    public function delete($request, $response, $args)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $id = $args['id'];
        $owner = Owner::findOrFail($id);
        if ($owner) {
            $owner->delete();
            $this->flash->addMessage('info', "Success delete Owner {$owner->title}!");
            return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
        }
        $this->flash->addMessage('error', "Failed delete Owner {$owner->title}!");
        return $response->withRedirect($this->router->pathFor('dash.merchant.owner'));
    }

}