<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 31/07/18
 * Time: 21:56
 */

namespace App\Exceptions;


use Illuminate\Support\Facades\DB;
use Throwable;

class IncompleteSolutionException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $message = "Ops.. para concluir o simulado você antes deve responder todas as questões!";
        parent::__construct($message, $code, $previous);
    }
}