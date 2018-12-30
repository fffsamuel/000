<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $fillable = ["description", "question_id", "correct"];
    public function question()
    {
    	return $this->belongsTo('App\Models\Question');
    }
}
