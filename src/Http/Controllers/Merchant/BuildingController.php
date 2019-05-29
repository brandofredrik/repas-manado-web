<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;

class BuildingController extends Controller
{

    public function index($request, $response)
    {
        $data = [
            'path' => 'merchant',
            'subpath' => 'building'
        ];
        return $this->view->render($response, 'merchants/building/index.twig', compact('data'));
    }

}