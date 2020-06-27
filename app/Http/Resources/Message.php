<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // '' => $this->id,
            // 'content' => $this->content,
            // 'user' => $this->user,
            // 'likes' => $this->likes->count(),
            // 'image' => $this->image,
            // 'created_at' => $this->created_at
            $this->user_id
        ];
    }
}
