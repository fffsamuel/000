<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\JobUploadQuestion;
use Illuminate\Support\Facades\Storage;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Answer;

class UploadController extends Controller
{

    public function processUploadedFile(Request $request){
        if ($request->file('file')->isValid()) { // Se o arquivo é válido
            $path = $request->file->store('tmp'); // Armazena o arquivo temporáriamente
            $count = 0;
            $topics = [];
            $questions = [];
            $file = Storage::get($path); // Abre o arquivo
            $buffer = collect(explode("\n", $file)); // Transforma o objeto em array de string
            $subject = new Topic;
            $subject->description = str_replace("Título ", "", preg_replace('~[[:cntrl:]]~', '', $buffer->shift())); // Cria o tópico pai
            $subject->id = null;
            $subject->parent_topic_id = 'subject';
            $topics[] = $subject;
            $topicsAux = [];
            // ---- Inicializa as variáveis ---- //
            $topic = null;
            $numberQuestions = -1;
            $question = null;
            $flagQuestion = false;
            $flagTopic = false;
            $answer = null;
            $answersMap = [];
            $questionExists = false;
            $qAux = null;
            
            foreach($buffer as $line) { // Cada linha do arquivo
                $line = preg_replace('~[[:cntrl:]]~', '', $line);
                // Se a linha começa com Cap de Capítulo
                if(preg_match('/^Cap/', $line)){
                    if($flagTopic){
                        $topicsAux = [];
                        $flagTopic = false;
                    }
                    $topic = new Topic;
                    $description = str_replace("Capítulo ", "", $line);
                    $topic->description = $description;
                    $topic->parent_topic_id = 'topic';
                    $position = explode(".", explode(" ", $description)[0]);
                    array_pop($position);
                    $topic->position = collect($position);
                    $topic->id = null;
                    $topics[] = $topic;
                    $topicsAux[] = $topic;
                }

                if(preg_match('/^Seção/', $line)){
                    $topic = new Topic;
                    $topic->description = str_replace("Capítulo ", "", $line);
                    $topic->parent_topic_id = 'topic';
                    $topic->id = null;
                    $topics[] = $topic;
                    $topicsAux[] = $topic;
                }

                if(preg_match('/^Título/', $line)){
                    $topic = new Topic;
                    $topic->description = str_replace("Título ", "", $line);
                    $topic->parent_topic_id = 'topic';
                    $topic->id = null;
                    $topics[] = $topic;
                    $topicsAux[] = $topic;
                }

                // Se a linha começa com um Q (Questões)
                // if(strcmp($numberQuestions.".", explode(" ", $line)[0]) == 0){
                if(preg_match('/^Q\d+$/', $line)){
                    $count++;                 
                    $question = new Question();
                    $question->identifier = $line;
                    $question->wording = '';
                }

                // Se a linha começa com Ano
                if(preg_match('/^Ano:/', $line)){
                    $question->year = trim(preg_replace("/[^[:alnum:][:space:]]/", '',explode(":", $line)[1]));
                }

                // Se a linha começa com Banca
                if(preg_match('/^Banca:/', $line)){
                    $question->board = trim(preg_replace("/[\x01-\x1F\x7F-\xFF]/", '', explode(":", $line)[1]));
                }

                // Se a linha começa com Órgão
                if(preg_match('/^Órgão:/', $line)){
                    $question->agency = trim(preg_replace("/[\x01-\x1F\x7F-\xFF]/", '', explode(":", $line)[1]));
                }
                
                // Se é uma descrição da questão
                if($flagQuestion){
                    if(preg_match('/^[a-e]\)/', $line)){
                        $flagQuestion = false;
                        if(!in_array($question->topics, $subject->toArray()))
                            $question->topics[] = $subject;
                        foreach ($topicsAux as $t) {
                            if(!in_array($question->topics, $t->toArray()))
                                $question->topics[] = $t;
                            
                        }
                        if(!in_array($questions, $question->toArray())){
                            $questions[] = $question;
                            $numberQuestions++;
                        }
                    }else{
                        $question->wording .= $line . "\n";
                    }
                    $flagTopic = true;
                }

                // Se a linha começa com Prova
                if(preg_match('/^Prova:/', $line)){
                    $question->exam = trim(preg_replace("/[\x01-\x1F\x7F-\xFF]/", '', explode(":", $line)[1]));
                    $flagQuestion = true;
                }

                // Se a linha começa com 'a', 'e', 'i', 'o' ou 'u', seguido de ')'
                if(preg_match('/^[a-e]\)/', $line)){
                    $answer = new Answer;
                    $answer->description = substr($line, 3);
                    $questions[$numberQuestions]->answers[] = $answer;
                }

                // Se a linha começa com Resposta:
                if(preg_match('/^Resposta: /', $line)){
                    $line = trim($line);
                    $answersMap[$line[strlen($line) - 1]]->correct = true;
                }

            }
            $job = dispatch(new JobUploadQuestion($path, $questions, $topics));
            Storage::delete($path);
            return json_encode($job);
        }
        return "Failed!";
    }
}
