<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 17/07/18
 * Time: 19:54
 */

namespace App\Http\Controllers;


use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController
{
    public function index(){
        return view('/dashboard/topics', ['topics' => Topic::all()]);
    }

    public function tree(){
        $roots = Topic::where('parent_topic_id', null)->orderBy('description')->get();
        $tree = collect([]);

        foreach ( $roots as $root ){
            if($root->children()->count() != 0)
                $root->children = $root->children()->get()->sortBy('description');
            $tree->push( $root->toNode() );
        }

        return $tree;
    }

    public function store(Request $request){
        $topic = Topic::find($request->topic_id);
        if(is_null($topic)){
            $topic = Topic::create([
                'description' => $request->description,
                'url' => $request->url,
                'parent_topic_id' => $request->parent_topic_id,
            ]);
        }else{
            $topic->description = $request->description;
            $topic->url = $request->url;
            $topic->save();
        }
        // $returnTopic = Topic::find($request->parent_topic_id);
        return $topic;
    }

    public function delete(Request $request){
        if(isset($request)){
            $topic = Topic::find($request->id);
            if(isset($topic)){
                $topic->delete();
            }
            return $request;
        }else{
            return response('Nenhum tópico foi selecionado.', 200);
        }
    }

    public function exchangeTopic(Request $request){
        if(isset($request)){
            $topic = Topic::find($request->id);
            if(isset($topic)){
                $topic->parent_topic_id = $request->parent_topic_id;
                $topic->save();
                return $topic;
            }
            return $request;
        }else{
            return response('Nenhum tópico foi selecionado.', 200);
        }
    }
}