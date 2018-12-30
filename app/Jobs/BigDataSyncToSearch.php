<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class BigDataSyncToSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $list;
    protected $page;
    protected $size;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Collection $list, $page = 1, $size = 100)
    {
        $this->list = $list;
        $this->page = $page;
        $this->size = $size;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( $this->size*$this->page > $this->list->count() ){
            return;
        }
        $this->list->forPage($this->page, $this->size)->searchable();
        self::dispatch( $this->list, $this->page+1, $this->size);
    }
}
