<?php

namespace App\Console\Commands;

use App\Repositories\ServerRepositoryInterface;
use Illuminate\Console\Command;
use App\Classes\SSHHelper;

class CheckMSStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $servers;
    protected $ssh;

    public function __construct(ServerRepositoryInterface $server)
    {
        $this->servers = $server;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
