<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Transaction;

class TransactionController extends Controller
{

    public function index($request, $response)
    {
        if (!isAdmin($this->auth->user()->role[0]->id))
            throw new \Slim\Exception\NotFoundException($request, $response);

        $transactions = Transaction::all();

        dd($transactions);
        $data = [
            'path' => 'transaction',
            'transactions' => $transactions
        ];

        return $this->view->render($response, 'transactions/index.twig', compact('data'));
    }

}