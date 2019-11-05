<?php

namespace App\Console\Commands;

use App\Classes\SSHHelper;
use Illuminate\Support\Str;
use App\Repositories\ScanRepositoryInterface;
use App\Repositories\ServerRepositoryInterface;
use Illuminate\Console\Command;

class CheckScanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkscanstatus {id}';

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
    protected $scans;
    protected $ssh;
    public function __construct(ServerRepositoryInterface $server, ScanRepositoryInterface $scan){
        $this->servers = $server;
        $this->scans = $scan;
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
        $scan_status = 0;
        $scan = $this->scans->findWhere([['id','=',$this->argument('id')],['scan_status','=',1]]);
        if($scan->count() == 0)
        {
            $this->error('No scan with that ID.');
        }
        else
        {
            $scan_servers = $this->servers->findWhere(['scan_id', '=', $this->argument('id')]);
            foreach($scan_servers as $server)
            {
                $this->ssh = new SSHHelper($server->uuid, $server->user, $server->ip, $server->port, $server->public_key, $server->private_key);
                if(Str::contains($this->ssh->read_file('/' . $server->user . '/7_fuckyoukut.json'), 'finished: 1'))
                {
                    $scan_status = 1;
                }
                else
                {
                    $scan_status = 0;
                }

            }
            if($scan_status === 1)
            {
                $this->scans->update($this->argument('id'), ['scan_status' => 2]);
                $this->info('Scan has finished.');
            }
        }
    }
}
