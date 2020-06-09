<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Comment_Image;
use App\Events\PostAdded;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=Comment::where('post_id',$_GET["post_id"])->orderBy('created_at', 'desc')->paginate(10);
        return CommentResource::collection($comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        $comment=new Comment([
            'user_id'=>Auth::user()->id,
            'post_id'=>$request->postId,
            'content'=>$request->content
        ]);
        $comment->save();
        if($request->hasFile('image')){
            $this->storeImage($request,$comment->id);
        }
        event(new PostAdded($comment));
        return response()->json($comment,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment=Comment_Image::find($id);
        return $comment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validateRequest(){
        if(request()->hasFile('image')){
            request()->validate([
                'image'=>'required|image',
            ]);
        }else{
            request()->validate([
                'content'=>'required',
            ]);
        }
    }

    private function storeImage($request,$commentId){
        $image=new Comment_Image();
        $image->image=$request->image->store('comments','public');
        $image->comment_id=$commentId;
        $image->save();
    }
}
