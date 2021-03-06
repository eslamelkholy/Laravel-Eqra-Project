<?php

namespace App\Http\Controllers;

use App\UserGenre;
use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GenreRequest;

class UserGenreController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->genres, 200);
    }

    public function store(GenreRequest $request)
    {
        Auth::user()->genres()->sync($request->genres);
        return response()->json(["message" => $request->genres], 201);
    }
}
