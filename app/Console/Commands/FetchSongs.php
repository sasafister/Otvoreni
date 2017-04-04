<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class FetchSongs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otvoreni:fetch-songs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch songs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(); //GuzzleHttp\Client
        $res = $client->get('https://lit-brushlands-62444.herokuapp.com/test');
        $this->info($res->getBody());
    }
}
