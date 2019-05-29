<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;

class OwnerController extends Controller
{

    public function index($request, $response)
    {
        $data = [
            'path' => 'merchant',
            'subpath' => 'owner'
        ];
        return $this->view->render($response, 'merchants/owner/index.twig', compact('data'));
    }

}