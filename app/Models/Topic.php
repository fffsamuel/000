<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	protected $fillable = ['description', 'parent_topic_id', 'url'];

    public function parent()
    {
    	return $this->belongsTo('App\Models\Topic', "parent_topic_id");
    }

    public  function children(){
        return $this->hasMany('App\Models\Topic', "parent_topic_id");
    }

    public function questions()
    {
    	return $this->belongsToMany('App\Models\Question');
    }

    public function toNode(){
        ($this->children->count() <= 9) ? $children_count = '0'.$this->children->count() : $children_count = $this->children->count();
        $video = '';
        $exchange = '';
        if(str_contains($this->url, 'watch?v=')){
            $this->url_id = str_after($this->url, 'watch?v=');
            $video = '<a href="#" id="video_topic" class="js-modal-btn" data-video-id="' . $this->url_id .'"><span class="fab fa-youtube"></span></a>';
        }
        if(str_contains($this->url, 'vimeo')){
            $url_div = explode("/", $this->url);
            $this->url_id = array_pop($url_div);
            $video = '<a href="#" id="video_topic" class="js-modal-btn" data-channel="vimeo" data-video-id="' . $this->url_id .'"><span class="fab fa-vimeo"></span></a>';
        }

        if(!is_null($this->parent)){
            $exchange = '<a href="#" id="exchange_topic" data-id="' . $this->id . '" data-parent-id="' . $this->parent_topic_id . '"><span class="fas fa-exchange-alt"></span></a>';
        }
        $node = [
            'id' => $this->id,
            'text' => '<div class="card card-topic">
                            <div class="row">
                                <div class="topic-number round-number ">
                                    <label class="number-inside-round">'. $children_count .'</label>
                                </div>
                                <div class="col col-md-6 col-xl-8 topic-text">                                
                                    <div class="color-orange"><a href="#" class="topic-link" data-id = ' . $this->id . ' data-description=' . $this->description . '>'
                                        . $this->description . ' ('.$this->questions->count() .')</a>
                                    </div>
                                </div>
                                <div class="col col-md-6 col-xl-4 text-right">
                                    <a class="topic-tree-node" data-id="" 
                                        data-id_parent_topic="' . $this->id . '" 
                                        data-description="' . $this->description . '">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="#" class="
                                        edit_topic" data-id="' . $this->id . '" 
                                        data-id_parent_topic="' . $this->parent_topic_id . '" 
                                        data-description="' . $this->description . '" 
                                        data-url="' . $this->url . '">
                                        <span class="fas fa-edit"></span>
                                    </a>'
                                     . $video . 
                                     // ''. $exchange .
                                    '<a href="#" id="delete_topic" 
                                        data-id="' . $this->id . '" 
                                        data-description="' . $this->description . '"
                                        data-id_parent_topic="' . $this->parent_topic_id . '" 
                                        data-children-count="' . $this->children->count() . '" 
                                        data-question-count="' . $this->questions->count() . '">
                                        <span class="fa fa-trash-alt"></span>
                                    </a>
                                </div>
                            </div>
                                              
                    </div>',
            'checked' => false,
            'hasChildren' => true,
            'children' => collect([])
        ];

        foreach ( $this->children as $child ){
            if($child->children()->count() != 0)
                if($child->children()->count() < 10)
                    $child->children = $child->children()->get()->sortBy('description');
                else
                    $child->children = $child->children()->get();

            $node['children']->push( $child->toNode());
        }
        return $node;
    }
}
