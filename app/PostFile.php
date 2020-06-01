<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    protected $fillable = ['post_id', 'filename'];
    
    // Inverse Relationship
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
