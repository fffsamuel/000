<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        \Mail::send('mail.contact_message', ['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'contact_message' => $request->message], function($message)
        {
        	$message->from('contato@soquestoes.com.br', 'Só Questões');
            $message->to('dhiegobroetto@gmail.com')->subject('Só Questões - Contato');
        });

        // return \Redirect::to('/');
    }
}
