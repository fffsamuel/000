<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        "title"
    ];

    public function author()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function doneBy()
    {
    	return $this->belongsToMany('App\Models\User' , 'exam_user');
    }

    public function questions()
    {
    	return $this->belongsToMany('App\Models\Question')->withPivot(['id']);
    }

    public function editableAndRemovable(){
         return (\Auth::user()->user_type != "STUDENT" && $this->question_type == "EXAM" && \Auth::user()->id == $this->author_id);
    }
}
