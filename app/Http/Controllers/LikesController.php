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
            ->select('full_name', 'id')->where('post_id', '=', $id)->paginate(10);
        // $arr = [];
        // for ($i = 0; $i < 100000; $i++) {
        //     for ($j = 0; $j < 100000; $j++) {
        //         $arr[$i] = $j;
        //     }
        // }
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
            ->select('full_name', 'id')->where('comment_id', '=', $id)->paginate(10);

        $arr = [];
        for ($i = 0; $i < 10000; $i++) {
            for ($j = 0; $j < 10000; $j++) {
                $arr[$i] = $j;
            }
        }
        return response()->json($users, 200);
    }


    public function pStore(Request $request)
    {

        $like = Plike::create([
            "post_id" => $request->post_id,
            "user_id" => $request->user_id
        ]);
        return response()->json(["like" => $like]);
    }

    public function cStore(Request $request)
    {
        $like = Clike::create([
            "comment_id" => $request->comment_id,
            "user_id" => $request->user_id
        ]);
        return response()->json(["like" => $like]);
    }

    public function pDestroy($post_id, $user_id)
    {
        Plike::where(["user_id" => $user_id, "post_id" => $post_id])->delete();
        return response()->json(["post" => $post_id, "user" => $user_id]);
    }

    public function cDestroy($comment_id, $user_id)
    {
        Clike::where(["user_id" => $user_id, "comment_id" => $comment_id])->delete();
        return response()->json(["post" => $comment_id, "user" => $user_id]);
    }

    public function checkForPlike($post_id, $user_id)
    {
        $res = Plike::where(["user_id" => $user_id, "post_id" => $post_id])->count();
        return response()->json(["res" => $res > 0]);
    }
    public function checkForClike($comment_id, $user_id)
    {
        $res = Clike::where(["user_id" => $user_id, "comment_id" => $comment_id])->count();
        return response()->json(['res' => $res > 0]);
    }
}
