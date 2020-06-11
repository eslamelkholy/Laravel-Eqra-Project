<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UseValidateRequest;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\Http\Requests\PostRequest;
use App\PostFile;


class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(UseValidateRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|confirmed'
        // ]);
        // if ($request->hasFile('avatar')) {
        //     $path = $request->file('avatar')->store('avatars');
        // } else {
        //     $path = Storage::url('avatar.jpg');
        // }
        // $request['pictur']=$path;
        $user = new User([
            'full_name' => $request->full_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;
        return response()->json([
            'message' => 'Successfully created user!',
            'access_token' => $tokenResult->accessToken,
            'role' => $user->role,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'role' => $user->role,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        // dd($request->all);
        if ($request->hasFile('pictur')) {
            $path = $request->file('pictur')->store('public/avatars');
            $url = Storage::url($path);
            dd($url);
        } else {
            $url = null;
        }
        $user->first_name = $request->first_name;
        $user->full_name = $request->full_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->pictur = $request->pictur;
        $user->save();

        return
            response()->json(['user' => $request, 'message' => "user updated successfully"], 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
      

        return response()->json([
            'user' => $request->user()
            // 'currentUserPosts' => PostResource::collection($posts),
            // 'currentUserComments' => $request->user()->comments,
        ]);
    }
    public function currentUsrPosts(){
        $userId= auth()->user()->id;
    
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(10);
        return PostResource::collection($posts);
    }
}
