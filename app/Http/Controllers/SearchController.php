<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public function searchQuery($params)
    {
        $users = User::where('full_name', 'LIKE', '%' .$params. '%')
                        ->orWhere('email', 'LIKE', '%' .$params. '%')->limit(8)
                        ->get();
        return response()->json(['users' => $users], 200);
    }
}
