<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use Auth;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(20);
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if(is_null($post))
            return response()->json(["message" => "Post Not Found" ], 404);
        return new PostResource($post);
    }

    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        if($request->hasFile('postFiles'))
            $this->uploadPostFiles($request, $post->id);
        return response()->json($post, 201);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if(is_null($post))
            return response()->json(["message" => "Post Not Found" ], 404);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if(is_null($post))
            return response()->json(["message" => "Post Not Found" ], 404);
        $post->delete();
        return response()->json(null, 204);
    }
    // Upload Files Handler
    public function uploadPostFiles($request, $postId){
        $files = $request->file('postFiles');
        foreach($files as $file){
            $filename = $file->store('postFiles');
            PostFile::create([
                'post_id' => $postId,
                'filename' => $filename
            ]);
        }
    }
}
