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

    public function massiveSearchProccessing($params)
    {
        $users = User::where('first_name', 'LIKE', '%' .$params. '%')
                        ->orWhere('last_name', 'LIKE', '%' .$params. '%')
                        ->orWhere('email', 'LIKE', '%' .$params. '%')
                        ->limit(30)
                        ->get();
        return response()->json(['users' => $users], 200);
    }
}
