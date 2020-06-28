<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Http\Resources\Follow as ResourcesFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Events\AddNewFollower;

class FollowController extends Controller
{
    public function getMyFollowers($id)
    {
        //  Auth::user()->id
        $data = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.follower_id')
            ->where('follows.followed_id', '=', $id)
            ->select('follows.follower_id', 'users.pictur', 'users.full_name')
            ->get();
        return response()->json($data);
    }

    public function getPersonsIFollow($id)
    {
        //  Auth::user()->id
        $data = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.followed_id')
            ->where('follows.follower_id', '=', $id)
            ->select('follows.followed_id', 'users.pictur', 'users.full_name')
            ->get();
        return response()->json($data);
    }

    public function getFollowersCount()
    {
        $data =
            [
                'followers' => DB::table('follows')
                    ->join('users', 'users.id', '=', 'follows.follower_id')
                    ->where('follows.followed_id', '=', Auth::user()->id)
                    ->select('follows.follower_id', 'users.pictur', 'users.full_name')
                    ->get()->count(),
                'following' => DB::table('follows')
                    ->join('users', 'users.id', '=', 'follows.followed_id')
                    ->where('follows.follower_id', '=', Auth::user()->id)
                    ->select('follows.followed_id', 'users.pictur', 'users.full_name')
                    ->get()->count()
            ];
        return response()->json($data);
    }

    public function follow($id)
    {
        $follow = Follow::where([['follower_id', Auth::user()->id], ['followed_id', $id]])->first();
        if (!is_null($follow))
            return response()->json($follow, 200);
        $follow = new Follow([
            'follower_id' => Auth::user()->id,
            'followed_id' => $id
        ]);
        $follow->save();
        event(new AddNewFollower($id));
        return response()->json($follow, 200);
    }

    public function unfollow($id)
    {
        Follow::where('followed_id', '=', $id)->delete();
        return ['status' => 'unfollow successfully'];
    }

    public function getFollowersData()
    {
        $followers = DB::table('follows')
            ->join('users', 'users.id', '=', 'follows.follower_id')
            ->where('follows.followed_id', '=',Auth::id())
            ->select('follows.follower_id', 'seen', 'role', 'follows.created_at' , 'users.pictur', 'users.full_name')
            ->get();
        return response([
            'myFollowers' => $followers,
            'seen' => $followers->where('seen', 0)->count()
        ], 200);
    }
    public function setUserFollowersSeen()
    {
        $followers = DB::table('follows')
            ->where('follows.followed_id', '=',Auth::id())
            ->update(['seen' => 1]);
        return response()->json(['update' => "Succesfully Update"], 200);
    }
    public function getFollowersFollowing()
    {
        $followingArray = []; 
        $followersArray=[];
           $following =Auth::user()->following()->get();
           $followers = Auth::user()->followers()->get();
        foreach ($following as $myFollowing) {
         $user=User::find($myFollowing->followed_id);
            array_push($followingArray,$user);
        }
        foreach ($followers as $myFollowers) {
            $user = User::find($myFollowers->follower_id);
            array_push($followersArray, $user);
        }
     
        return response()->json([
            'followingArray' =>$followingArray,
            'followersArray' => $followersArray,
            'user' => Auth::user()

        ], 200);
    }
}
