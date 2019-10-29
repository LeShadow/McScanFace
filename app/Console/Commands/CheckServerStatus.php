<?php

namespace App\Console\Commands;

use App\Repositories\ServerRepositoryInterface;
use Illuminate\Console\Command;
use Ssh\Configuration;
use Ssh\Authentication\PublicKeyFile;
use Ssh\Session;
use Storage;
class CheckServerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkserverstatus';

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
    public function __construct(ServerRepositoryInterface $server){
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
        $servers_to_check = $this->servers->findWhere(['name', 'LIKE', '%Heimdall%']);
        foreach($servers_to_check as $server)
        {

            Storage::put($server->uuid . '-public', $server->public_key);

            Storage::put($server->uuid . '-private', $server->private_key);
            $ssh_config = new Configuration($server->ip);
            $ssh_auth = new PublicKeyFile($server->user, Storage::disk('local')->path($server->uuid . '-public'), Storage::disk('local')->path($server->uuid . '-private'), '');
            $session = new Session($ssh_config, $ssh_auth);
            try {
                $exec = $session->getExec();
                $this->servers->update($server->id, ['status' => 0]);
                Storage::delete($server->uuid . '-public');
                Storage::delete($server->uuid . '-private');
            }
            catch(Exception $e) {
                $this->servers->update($server->id, ['status' => 1]);
            }



        }

    }
}
