<?php

use App\Models\Exam;
use App\Models\Question;

Auth::routes();

Route::get('/', function() { return view('landingPage'); });
Route::get('/home', 'HomeController@index')->name('home');
if(env('AMBIENTE') == 'DEVELOP'){
    Route::get('/upload', function (){ return view('/upload/upload'); });
}
Route::get('/deleteQuestions', 'QuestionController@deleteInMass');
Route::post('contact_me', 'ContactController@sendMessage');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth' ], function(){
    Route::get('refresh', 'QuestionController@refreshIndexes');

    Route::get('/', function() { return view('/layouts/dashboard'); });
    Route::get('/home', function() { return view('/dashboard/home'); });

    // Importador de dados
    Route::group(['prefix' => 'upload'], function (){
        Route::post('/', 'UploadController@processUploadedFile');
    });

    // Questions
    Route::group(['prefix' => 'questions'], function (){
        Route::get('/', function() { return view('/dashboard/questions'); });
        Route::get('create', 'QuestionController@index');
        Route::post('store', 'QuestionController@store');
        Route::post('delete', 'QuestionController@delete');
        Route::post('exists', 'QuestionController@exists');
        Route::get('search', 'QuestionController@search');
        Route::post('comments', 'QuestionController@add_comment');
    });

    // Image Controller
    Route::group(['prefix' => 'images'], function (){
        Route::post('/', 'ImageController@store');
        Route::get('{filename}', 'ImageController@get');
    });

    // User's profile
    Route::group(['prefix' => 'user'], function (){
        Route::get('/', function() { return view('/dashboard/user'); });
        Route::post('/', 'UserController@store');
        Route::post('deleteAvatar', 'UserController@deleteAvatar');
        Route::post('store', 'UserController@store');
    });

    // Topics
    Route::group(['prefix' => 'topics'], function (){
        // Route::get('/', function() { return view('/dashboard/topics'); });
        Route::get('/', 'TopicController@index');
        Route::post('/', 'TopicController@store');
        Route::get('tree', 'TopicController@tree' );
        Route::post('delete', 'TopicController@delete');
        Route::post('exchange', 'TopicController@exchangeTopic');
    });

    if(env('AMBIENTE') == 'DEVELOP'){
        // Exams
        Route::group(['prefix' => 'exams'], function (){
            Route::get('/', function() { return view('/dashboard/exams'); });
            Route::get('create','ExamController@create');
            Route::post('add_question','ExamController@add_question');
            Route::post('remove_question','ExamController@remove_question');
            Route::post('store', 'ExamController@store');
            Route::post('answer_question','ExamController@answer_question');
            Route::post('store','ExamController@store');
            Route::post('answer_question','ExamController@answer_question');
        });

        // simulations
        Route::group(['prefix' => 'simulations'], function (){
            Route::get('/', function() { return view('/dashboard/simulations'); });
            Route::get('create','SimulationController@create');
            Route::get('{id}/{exam_user_id}', 'SimulationController@get');
            Route::post('store', 'SimulationController@store');
            Route::get('display_question', 'SimulationController@display_question');
            Route::post('finish_simulation', 'SimulationController@finish_simulation');
        });
        
        // Backups
        Route::group(['prefix' => 'backups'], function (){
            Route::get('/', function() { return view('/dashboard/backups'); });
            Route::post('create', 'BackupController@create');
            Route::post('load',   'BackupController@load');
            Route::get('get_snapshot',   'BackupController@get_snapshot');
        });
    }

    // Search questions
    Route::get('/search/{search}', function ($search) {
        return view('/dashboard/questions' ,[ 'search' => $search ] );
    });
    Route::get('/search/topic/{id}', 'QuestionController@searchTopics');

});