<?php

namespace App\Http\Controllers;

use App\Clike;
use Illuminate\Http\Request;
use App\Plike;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{
    public function plikes($id)
    {
        // $likes = Plike::where(['post_id' => $id])->paginate(10);
        // $users = [];
        // foreach ($likes as $like) {
        //     array_push($users, $like->user);
        // }
        $users = DB::table('users')->join('plikes', 'id', '=', 'user_id')
            ->select('name')->where('post_id', '=', $id)->paginate(10);
        return response()->json($users, 200);
    }
    public function clikes($id)
    {
        // $likes = Clike::where(['comment_id' => $id])->paginate(10);
        // $users = [];
        // foreach ($likes as $like) {
        //     array_push($users, $like->user);
        // }
        $users = DB::table('users')->join('clikes', 'id', '=', 'user_id')
            ->select('name')->where('comment_id', '=', $id)->paginate(10);
        return response()->json($users, 200);
    }
}
