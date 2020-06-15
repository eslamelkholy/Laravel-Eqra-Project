<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class ElasticController extends Controller
{
    public function trends()
    {
        // Post::createIndex($shards = null, $replicas = null);
        // Post::putMapping($ignoreConflicts = true);
        Post::addAllToIndex();


        $writers = User::select(['full_name', 'id'])->where(['role' => 'writer'])->get();

        $trends = [];
        foreach ($writers as $writer) {
            $data = Post::complexSearch(array(
                'body' => array(
                    'query' => array(
                        'match' => array(
                            'body_content' => $writer->full_name
                        )
                    )
                )
            ));
            $posts['count'] = $data->count();
            $posts['posts'] = $data;
            $posts['writer'] = $writer;
            array_push($trends, $posts);
        }
        usort($trends, function ($a, $b) {
            return ($a["count"] >= $b["count"]) ? -1 : 1;
        });


        return response()->json(['data' => array_slice($trends, 0, 5)]);
        // return $posts;
        // $typeExists = Post::typeExists();
        // dd($typeExists);
    }
}
