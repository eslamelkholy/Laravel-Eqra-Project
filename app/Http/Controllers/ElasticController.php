<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class ElasticController extends Controller
{
    public function getData()
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
            $posts['posts'] = $data;
            $posts['writer'] = $writer;
            array_push($trends, $posts);
        }



        return response()->json(['data' => $trends]);
        // return $posts;
        // $typeExists = Post::typeExists();
        // dd($typeExists);
    }
}
