<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use Searchable;

    protected $fillable = [
        "year", 
        "board", 
        "agency", 
        "exam", 
        "wording", 
        "identifier"
    ];
    public function comments()
    {
    	return $this->hasMany('App\Models\Comment');
    }

    public function answers()
    {
    	return $this->hasMany('App\Models\Answer');
    }

    public function topics()
    {
    	return $this->belongsToMany('App\Models\Topic');
    }

    public function exams()
    {
    	return $this->belongsToMany('App\Models\Exam');
    }

    public function toSearchableArray()
    {
        $array = $this->only('id','year', 'board', 'agency', 'exam', 'wording', 'identifier');
        $answers = $this->answers->toArray();
        $topics = $this->topics->toArray();
        $i = 1;
        foreach ($answers as $a) {
            $array["extra_field_{$i}"] = $a['description'];
            $i++;
        }
        foreach ($topics as $t) {
            $array["extra_field_{$i}"] = $t['description'];
            $i++;
        }

        return $array;
    }

    public static function unique($key){
        return DB
            ::table('questions')
            ->selectRaw("distinct {$key}")
            ->orderBy($key)
            ->get()
            ->pluck($key)
            ->all();
    }
}
