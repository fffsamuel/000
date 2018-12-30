<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Utils\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function store(Request $request){
        $exam = new Exam;
        $exam->title = $request->title;
        $exam->exact_solution = '0';
        $exam->author()->associate( Auth::user() );
        $exam->question_type = 'EXAM';
        $exam->save();
        return $exam;
    }

    public function add_question(Request $request){
        $exam = Exam::find($request->exam_id);
        $exam->questions()->attach($request->question_id);

        return view('dashboard.question_added', ['exam' => $exam]);
    }

    public function remove_question(Request $request){
        $exam = Exam::find($request->exam_id);
        $exam->questions()->detach($request->question_id);

        return view('dashboard.question_added', ['exam' => $exam]);
    }

    public function answer_question(Request $request){

        $actual_solution = Solution::getSolution($request->exam_user_id);
        $answer = Answer::find($request->answer_id);
        $question = $answer->question;

        $actual_solution[ $question->id ] = $answer->id;

        Solution::updateSolution( $request->exam_user_id, $actual_solution );
        return 0;
    }

    public function create(Request $request){
        return view('/dashboard/exam_form', [
            'exam' => Exam::firstOrNew(['id'=> $request->exam_id])
        ]);
    }
}
