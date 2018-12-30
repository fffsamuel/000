<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use App\Jobs\JobRefreshIndexes;

class QuestionController extends Controller
{
    public function index(Request $request){
        $attr['question'] = Question::firstOrNew(['id'=> $request->question_id]);
        $attr['user_topics_array'] = array();
        if($attr['question']->topics->count() > 0){
            foreach ($attr['question']->topics as $topic) {
                $attr['user_topics_array'][] = $topic->id;
            }
            $attr['user_topics'] = $attr['question']->topics;
        }
        $attr['topics'] = Topic::all();       
        return view('/dashboard/question_form', $attr); 
    }

    public function store(Request $request)
    {
        $question = Question::updateOrCreate(
            ['id' => $request->question_id],
            [
                'wording' => $request->question_wording,
                'year' => $request->year,
                'agency' => $request->agency,
                'board' => $request->board,
                'exam' => $request->exam,
                'identifier' => $request->identifier
            ]
        );

        $question->topics()->detach();

        $question->topics()->attach($request->topics);
        
        $question->answers()->delete();

        foreach ($request->answers as $a) {
            Answer::create([
                'question_id' => $question->id,
                'description' => $a['answer_wording'],
                'correct' => $a['right_one'] 
            ]);
        }

        return $question->id;
    }

    public function delete(Request $request){
        if(isset($request)){
            Question::destroy($request->id);
            return response('Questão com id = ' . $request->id . ' foi apagada com sucesso.', 200);
        }else{
            return response('Nenhuma questão foi selecionada.', 200);
        }
    }

    public function exists(Request $request){
        return Question::select('id')->where('identifier', '=', $request->identifier)->first();
    }

    public function searchTopics(Request $request){
        return view('dashboard/questions', ['id' => $request->id]);
    }

    public function search(Request $request){
        return view('dashboard.question_picker', [
            'search' => $request->search,
            'exam' => Exam::find($request->exam_id)
        ]);
    }

    public function deleteInMass(){
        return Question::where('id', '>=', 1)->delete();
    }

    public function add_comment(Request $request){
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'question_id' => $request->question_id,
            'descripton' => $request->description
        ]);
        return [
            'author_name' => Auth::user()->name,
            'date' => $comment->data_formatada,
            'description' => $comment->descripton
        ];
    }

    public function refreshIndexes(){
        // exec('rm -rf storage/questions.index*');
        header("Refresh: 0; url = /dashboard");
        return json_encode(dispatch(new JobRefreshIndexes()));
    }
}
