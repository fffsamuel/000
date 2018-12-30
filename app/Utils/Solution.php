<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 28/07/18
 * Time: 21:10
 */

namespace App\Utils;


use App\Exceptions\IncompleteSolutionException;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class Solution
{
    public static function getSolution( $exam_user_id ){
        return unserialize(DB::table('exam_user')
            ->select('exam_user.solution')
            ->where('id',$exam_user_id)
            ->first()
            ->solution
        );
    }

    public static function updateSolution( $exam_user_id, $solution ){
        DB::update('update exam_user set solution=? where id=?',[
            serialize($solution),
            $exam_user_id
        ]);
    }

    public static function emptySolution()
    {
        return serialize([]);
    }

    public static function getState($exam_user_id)
    {
        return DB::table('exam_user')
            ->select('exam_user.state')
            ->where('id',$exam_user_id)
            ->first()
            ->state;
    }

    public static function finish($exam_user_id)
    {
        self::checkIfSolutionIsComplete($exam_user_id);
        DB::update('update exam_user set state=? where id=?', ['COMPLETED', $exam_user_id] );
        return self::getScore($exam_user_id);
    }

    private static function getExam($exam_user_id)
    {
        return Exam::find(DB::table('exam_user')
            ->select('exam_user.exam_id')
            ->where('id',$exam_user_id)
            ->first()
            ->exam_id
        );
    }

    public static function getScore($exam_user_id)
    {
        $solution = self::getSolution($exam_user_id);
        $exam = self::getExam($exam_user_id);

        $rights = 0;
        $wrongs = 0;
        foreach ($exam->questions as $question) {
            foreach ($question->answers as $answer) {
                if ($answer->correct) {
                    if (isset($solution[$question->id]) && $solution[$question->id] == $answer->id) {
                        $rights++;
                    } else {
                        $wrongs++;
                    }
                }
            }
        }
        return array($rights, $wrongs);
    }

    public static function getStateH($exam_user_id)
    {
        switch ( self::getState($exam_user_id) ){
            case 'IN_PROGRESS' : return 'Em Progresso';
            case 'COMPLETED' : return 'Completo';
            default: return 'n/d';
        }
    }

    private static function checkIfSolutionIsComplete($exam_user_id)
    {
        $solution = self::getSolution($exam_user_id);
        $exam = self::getExam($exam_user_id);

        foreach ($exam->questions as $question) {
            if (!isset($solution[$question->id])) {
                throw new IncompleteSolutionException();
            }
        }
    }
}