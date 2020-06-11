<?php

namespace App\Http\Controllers;

use App\Events\PostAdded;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use  Auth;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\PostRequest;
use App\PostFile;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post))
            return response()->json(["message" => "Post Not Found"], 404);
        return new PostResource($post);
    }

    public function store(PostRequest $request)
    {
        $request['user_id'] = Auth::id();
        $post = Post::create($request->all());
        if ($request->hasFile('postFiles'))
            $this->uploadPostFiles($request, $post->id);
        // event(new PostAdded($post));
        return response()->json($post, 201);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (is_null($post))
            return response()->json(["message" => "Post Not Found"], 404);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if (is_null($post))
            return response()->json(["message" => "Post Not Found"], 404);
        $post->delete();
        return response()->json(["id" => $id], 204);
    }
    // Upload Files Handler
    public function uploadPostFiles($request, $postId)
    {
        $files = $request->file('postFiles');
        foreach ($files as $file) {
            $filename = $file->store('postFiles');
            PostFile::create([
                'post_id' => $postId,
                'filename' => $filename
            ]);
        }
    }
}
