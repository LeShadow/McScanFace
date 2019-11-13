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

    public function __construct(ServerRepositoryInterface $server, ScanRepositoryInterface $scan)
    {
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
        $scan_status = true;
        $scan = $this->scans->findWhere([['id', '=', $this->argument('id')], ['scan_status', '=', 1]]);
        if ($scan->count() == 0) {
            $this->error('No scan with that ID.');
        } else {
            $scan_servers = $this->servers->findWhere(['scan_id', '=', $this->argument('id')]);
            foreach ($scan_servers as $server) {
                $this->ssh = new SSHHelper($server->uuid, $server->user, $server->ip, $server->port, $server->public_key, $server->private_key);
                $scan_status = Str::contains($this->ssh->read_file('/' . $server->user . '/'.$scan[0]->id . '_' . str_replace(' ', '_', $scan[0]->name).'.json'), 'finished: 1');
                //
                // Masscan version supported: 1.0.4, we really on the finish tag. for version 5, we'll have to check the process list to see if it finished. Or add extra file
                //
                if($scan_status == false){
                    break;
                }
            }

            if ($scan_status) {
                $this->scans->update($this->argument('id'), ['scan_status' => 2]);
/*                foreach ($scan_servers as $server) {
                    $this->servers->update($server->id, ['scan_id' => 0]);
                }*/
                $this->info('Scan has finished.');
            }
        }
    }
}
