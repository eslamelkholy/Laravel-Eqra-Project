<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(Request $request)
    {
        // accept new book and store it
    }

    public function buy(Request $request)
    {
        // take money and send 90% of it to writer account and the rest to site account
        // give user one time link to download book pdf
    }
}
