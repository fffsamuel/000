<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Utils\Solution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimulationController extends Controller
{
    public function store( Request $request ){
        // criação do simulado
        $exam = new Exam;
        $data  = Carbon::now()->format('d/m/y H:i');
        $name = Auth::user()->name;
        $exam->title = "{$data} - Simulado de {$name}";
        $exam->question_type = 'SIMULATION';
        $exam->exact_solution = 'foo';
        $exam->author()->associate(Auth::user());
        $exam->save();

        // associando questões ao exame
        $qb = DB::table('questions')->select('questions.id');

        switch ( $request->simulation_create_mode ){
            case 'T': /* topico */
                $qb
                ->join('question_topic','questions.id','=','question_topic.question_id')
                ->whereIn('question_topic.topic_id', $request->topics);
                break;
            case 'O': /* agency */
                $qb->where('questions.agency','like', "%{$request->agency}%");
                break;
            case 'B': /* board */
                $qb->where('questions.board','like', "%{$request->board}%");
                break;
            case 'P': /* exam */
                $qb->where('questions.exam','like', "%{$request->exam}%");
                break;
        }

         $selected_questions = $qb
            ->inRandomOrder()
            ->limit($request->number_questions)
            ->distinct('questions.id')
            ->get()
            ->map(function($q){ return $q->id; })
            ->toArray();

        $exam->questions()->attach($selected_questions);
        $exam->doneBy()->attach(Auth::user(),[
            'solution' => Solution::emptySolution()
        ]);
        $exam_user_id = Auth::user()
            ->doneSimulations()
            ->wherePivot('exam_id',$exam->id)
            ->latest()
            ->first()
            ->pivot
            ->id;

        return [ 'simulation_id' => $exam->id, 'exam_user_id' => $exam_user_id ];
    }

    public function create(Request $request){
        return view('/dashboard/simulation_form', [
            'simulation' => Exam::firstOrNew(['id'=> $request->simulation_id])
        ]);
    }

    public function get(Request $request){
        return view('dashboard/simulation',[
            'simulation' => Exam::find($request->id),
            'exam_user_id' => $request->exam_user_id
        ]);
    }

    public function display_question(Request $request){
        $simulation = Exam::find($request->simulation_id);
        $questions = $simulation->questions()->paginate($request->paginate);
        return view('dashboard/solvable_question', [
            'size' => $simulation->questions->count(),
            'exam_user_id' => $request->exam_user_id,
            'questions' => $questions,
            'page' => $request->page,
            'total_page' => $questions->lastPage()
        ]);
    }

    public function finish_simulation(Request $request ){
        try{
            [$rights, $wrongs] = Solution::finish($request->exam_user_id);
            return [ 'rights' => $rights, 'wrongs' => $wrongs ];
        } catch( \Exception $e ){
            return response($e->getMessage(), 403);
        }

    }
}
