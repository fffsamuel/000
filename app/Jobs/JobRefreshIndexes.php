<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Artisan;
use TeamTNT\Scout\Engines\TNTSearchEngine;
use TeamTNT\Scout\TNTSearchScoutServiceProvider;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;
use TeamTNT\TNTSearch\TNTSearch;

class JobRefreshIndexes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
        Artisan::call("tntsearch:import",["model"=>"App\Models\Question"]);
        return response('Pesquisa atualizada! ', 200);
    }
}
