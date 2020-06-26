<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Http\Resources\Follow as ResourcesFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function getMyFollowers($id)
    {
        //  Auth::user()->id
        $data = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.follower_id')
            ->where('follows.followed_id', '=',$id)
            ->select('follows.follower_id', 'users.pictur', 'users.full_name')
            ->get();
        return response()->json($data);
    }

    public function getPersonsIFollow($id)
    {
        //  Auth::user()->id
        if($id=='user'){
            $data = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.followed_id')
            ->where('follows.follower_id', '=',Auth::user()->id)
            ->select('follows.followed_id', 'users.pictur', 'users.full_name')
            ->get();
            return response()->json($data);
        }
        $data = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.followed_id')
            ->where('follows.follower_id', '=',$id)
            ->select('follows.followed_id', 'users.pictur', 'users.full_name')
            ->get();
        return response()->json($data);
    }

    public function getFollowersCount(){
        $data=
        [
        'followers'=>DB::table('follows')
            ->join('users','users.id','=','follows.follower_id')
            ->where('follows.followed_id','=',Auth::user()->id)
            ->select('follows.follower_id','users.pictur','users.full_name')
            ->get()->count(),
        'following'=>DB::table('follows')
            ->join('users','users.id','=','follows.followed_id')
            ->where('follows.follower_id','=',Auth::user()->id)
            ->select('follows.followed_id','users.pictur','users.full_name')
            ->get()->count()
        ];
        return response()->json($data);
    }

    public function follow($id){
        $follow = Follow::where([['follower_id', Auth::user()->id], ['followed_id', $id]])->first();
        if(!is_null($follow))
            return response()->json($follow, 200);
        $follow=new Follow([
            'follower_id'=>Auth::user()->id,
            'followed_id'=>$id
        ]);
        $follow->save();
        return response()->json($follow, 200);
    }

    public function unfollow($id)
    {
        Follow::where('followed_id', '=', $id)->delete();
        return ['status' => 'unfollow successfully'];
    }

    public function getFollowersIds()
    {
        return response(['myFollowersIds' => Auth::user()->following()->pluck('followed_id')->toArray()], 200);
    }
}
