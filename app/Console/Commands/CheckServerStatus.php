<?php
namespace App\Console\Commands;

use App\Repositories\ServerRepositoryInterface;
use Illuminate\Console\Command;
use App\Classes\SSHHelper;
use phpseclib\Net\SSH2;
use phpseclib\Crypt\RSA;
use Illuminate\Support\Str;
define('NET_SSH2_LOGGING', 2);
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
        $servers_to_check = $this->servers->all();
        foreach ($servers_to_check as $server) {

            $this->ssh = new SSHHelper($server->uuid, $server->user, $server->ip, $server->port, $server->public_key, $server->private_key);
            $server_status = $this->ssh->isOnline();
            $this->servers->update($server->id, ['status' => $server_status]);
            if ($server_status) {
                $command_output = $this->ssh->command('which masscan');
                if ($command_output !== false && Str::contains($command_output, 'bin/masscan')) {
                    $this->servers->update($server->id, ['masscan_install_status' => 1]);
                } else {
                    $this->servers->update($server->id, ['masscan_install_status' => 0]);
                }
            }

        }

    }
}
