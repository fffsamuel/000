<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','question_id','descripton'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }

	public function question()
    {
    	return $this->belongsTo('App\Models\Question');
    }

    public function getDataFormatadaAttribute(){
        return $this->created_at->format('d/m/Y à\s H:i:s');
    }

}
