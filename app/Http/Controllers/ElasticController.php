<?php

namespace App\Http\Controllers;

use App\Plike;
use App\Post;
use App\PostFile;
use App\PostGenre;
use App\User;
use Illuminate\Http\Request;

class ElasticController extends Controller
{
    public function trends()
    {
        // Post::createIndex($shards = null, $replicas = null);
        // Post::putMapping($ignoreConflicts = true);
        Post::addAllToIndex();


        $writers = User::select(['full_name', 'id', "username"])->where(['role' => 'writer'])->get();

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

    public function getWriterPosts(Request $request, $name)
    {
        Post::addAllToIndex();
        $page = $request->input('page');
        $data = Post::searchByQuery(array('match' => array('body_content' => $name)));
        foreach ($data as $d) {
            $d['user'] = User::find($d['user_id']);
            $d['likes'] = Plike::where(['post_id' => $d['id']])->count();
            $d['files'] = PostFile::where('post_id', $d['id'])->get();
            // $d['genres'] = PostGenre::where('post_id', $d['id'])->get();
        }
        return response()->json(['data' => array_slice($data->toArray(), ($page - 1) * 10, 10), 'last_page' => (int) ($data->count() / 10) + 1]);
    }
}
