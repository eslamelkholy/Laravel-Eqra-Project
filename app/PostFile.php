<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    protected $fillable = ['post_id', 'filename'];
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
