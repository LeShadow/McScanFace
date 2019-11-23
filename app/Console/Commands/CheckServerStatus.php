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
                    // This is a chain of commands which will update the server package lists, download masscan source, build it and copy the binary to /usr/bin
                    //
                    // TODO: We should first find out what package provider this server has (apt, yum, dnf, zypper,...). But since this a proof of concept for now, this will be on the todolist
                    //
                    $install_masscan_command = $this->ssh->command('apt-get update && apt-get install git gcc make libpcap-dev -y && wget https://github.com/robertdavidgraham/masscan/archive/1.0.4.tar.gz && tar zxvf 1.0.4.tar.gz && cd masscan-1.0.4 && make && mv bin/masscan /usr/bin/masscan');
                    $check_masscan_install = $this->ssh->command('which masscan');
                    if ($install_masscan_command !== false && Str::contains($check_masscan_install, 'bin/masscan'))
                    {
                        $this->servers->update($server->id, ['masscan_install_status' => 1]);
                    }
                    else
                    {
                        $this->servers->update($server->id, ['masscan_install_status' => 0]);
                    }
                }
            }

        }

    }
}
