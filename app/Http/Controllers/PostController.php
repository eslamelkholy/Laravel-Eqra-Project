<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\PostFile;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /*
        /api/post       [ GET ]   >> List All Posts
        /api/post       [ POST ]  >> Add New Post
        /api/post/id    [ GET ]   >> Get Post
        /api/post/id    [ PUT ]   >> Update POST
        /api/post/id    [ Get ]   >> Delete POST
    */
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
    /**
     * Create new Post
     * @param  [text] body_content
     * @param  [text] user_od
     * @param  [file] postFiles[]
     */
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
        $allowedfileExtension=['pdf','jpg','png','docx', 'mp3', 'mp4', 'docx', 'pdf', 'txt'];
        $files = $request->file('postFiles');
        foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check){
                foreach ($request->postFiles as $postFile) {
                    $filename = $postFile->store('postFiles');
                    PostFile::create([
                        'post_id' => $postId,
                        'filename' => $filename
                    ]);
                }
            }
        }
    }
}