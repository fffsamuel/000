<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store( Request $request ){

        $path = $request->file('image')->store('question_images');
        return explode("/", $path)[1];
    }

    public function get( Request $request ){
        return Image::make(storage_path("app/question_images/{$request->filename}"))->response();
    }
}
