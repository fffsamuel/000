<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function create(){

        $name =  rand().time();
        Artisan::call('snapshot:create', ['name' => $name]);
        return compact('name');
    }

    public function get_snapshot(Request $request){
        return response()->download(database_path("snapshots/{$request->name}.sql"));
    }

    public function load(Request $request){

        $name =  rand().time();
        Storage::disk('snapshots')
        ->putFileAs("/", $request->file('snapshot'), "{$name}.sql");

        Artisan::call('snapshot:load', ['name' => $name]);

        return 0;
    }
}
