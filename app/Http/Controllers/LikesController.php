<?php

namespace App\Http\Controllers;

use App\Clike;
use Illuminate\Http\Request;
use App\Plike;

class LikesController extends Controller
{
    public function plikes($id)
    {
        dd($id);
        $likes = Plike::where(['post_id' => $id])->paginate(20);
        return response()->json($likes, 200);
    }
    public function clikes($id)
    {
        $likes = Clike::where(['comment_id' => $id])->paginate(20);
        return response()->json($likes, 200);
    }
}
