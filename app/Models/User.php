<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'user_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userScope()
    {
        switch ($this->user_type) {
            case 'ADMIN':
                return $this->hasOne('App\Models\Admin');
            case 'TEACHER':
                return $this->hasOne('App\Models\Teacher');
            case 'STUDENT':
                return $this->hasOne('App\Models\Student');                        
        }
    }

    public function createdExams()
    {
        return $this->hasMany('App\Models\Exam', "author_id")->where('question_type', '=', \Config::get('constants.exam_type.exam'));
    }

    public function doneExams()
    {
        return $this->belongsToMany('App\Models\Exam')->where('question_type', '=', \Config::get('constants.exam_type.exam'));
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function createdSimulations(){
        return $this->hasMany('App\Models\Exam', "author_id")->where('question_type', '=', \Config::get('constants.exam_type.simulation'));
    }

    public function doneSimulations()
    {
        return $this->belongsToMany('App\Models\Exam')
            ->withPivot('id','solution')
            ->where('question_type', '=', \Config::get('constants.exam_type.simulation'));
    }
}
