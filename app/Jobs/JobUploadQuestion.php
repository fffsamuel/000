<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Answer;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use TeamTNT\Scout\Engines\TNTSearchEngine;
use TeamTNT\Scout\TNTSearchScoutServiceProvider;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;
use TeamTNT\TNTSearch\TNTSearch;

class JobUploadQuestion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;
    private $questions;
    private $topics;
    private $questionsFromUpload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, $questions, $topics)
    {
        $this->path = $path;
        $this->questions = $questions;
        $this->topics = $topics;
        $this->questionsFromUpload = collect([]);
    }
    public $timeout = 400;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Question::withoutSyncingToSearch(function () {
            \DB::beginTransaction();
            $s = null;
            for ($i = 0; $i < sizeof($this->topics); $i++) {
                if($this->topics[$i]->parent_topic_id == "subject"){
                    $s = Topic::firstOrCreate(['description' => $this->topics[$i]->description],[
                        "description" => $this->topics[$i]->description
                    ]);
                    $this->topics[$i]->id = $s->id;
                }
                elseif ($this->topics[$i]->parent_topic_id == "topic") {
                    if(sizeof($this->topics[$i]->position) < 2){
                        $this->topics[$i]->parent_topic_id = $s->id;
                    }
                    else{
                        foreach ($this->topics as $parentTopic) {
                            if($this->topics[$i]->position == $parentTopic->position){
                                break;
                            }
                            $last = $this->topics[$i]->position->pop();
                            if($this->topics[$i]->position == $parentTopic->position){
                                $this->topics[$i]->parent_topic_id = $parentTopic->id;
                                $this->topics[$i]->position->push($last);
                                break;
                            }
                            $this->topics[$i]->position->push($last);
                        }
                    }
                     if($s->wasRecentlyCreated){ 
                        $top = Topic::create([ 
                            "description" => $this->topics[$i]->description, 
                            "parent_topic_id" => $this->topics[$i]->parent_topic_id 
                        ]); 
                    }else{ 
                        $top = Topic::firstOrCreate(['description' => $this->topics[$i]->description],[
                            "description" => $this->topics[$i]->description,
                            "parent_topic_id" => $this->topics[$i]->parent_topic_id
                        ]);
                    }
                    $this->topics[$i]->id = $top->id;
                }
            }
            foreach ($this->questions as $q) {
                $createdQuestion = Question::firstOrCreate(['identifier' => $q->identifier], [
                    "year" => $q->year,
                    "board" => $q->board, 
                    "agency" => $q->agency,
                    "exam" => $q->exam,
                    "wording" => $q->wording,
                    "identifier" => $q->identifier
                ]);
                $this->questionsFromUpload->push($createdQuestion);
                if($createdQuestion->wasRecentlyCreated){
                    foreach ($q->topics as $t) {
                        foreach ($this->topics as $top) {
                            if($t->description == $top->description){
                                $createdQuestion->topics()->attach($top);
                                break;
                            }
                        }
                    }
                    foreach ($q->answers as $a) {
                        $answer = Answer::create([
                            "description" => $a->description,
                            "question_id" => $createdQuestion->id
                        ]);
                    }
                }else{
                    foreach ($q->topics as $t) {
                        if(!$createdQuestion->topics->contains($t->id)){
                            $createdQuestion->topics()->attach($t);
                        }
                    }
                }
            }
            \DB::commit();
        });
        Artisan::call("tntsearch:import",["model"=>"App\Models\Question"]);
        return response('Arquivo processado com sucesso! ', 200);
    }
}
