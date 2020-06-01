<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'body_content' => $this->body_content,
            'user_id' => $this->user,
            'created_at' => $this->created_at
        ];
    }
    public function with($request){
        return [
            'version' => '1.0.0',
            'posts_url' => url("http://127.0.0.1:8000/api/post")
        ];
    }
}
