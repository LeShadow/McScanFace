<?php

namespace App\Classes;
use RuntimeException;
use Ssh\Configuration;
use Ssh\Authentication\PublicKeyFile;
use Ssh\Session;
use Illuminate\Support\Str;
use Storage;

Class SSHHelper {

    protected $uuid;
    protected $user;
    protected $port;
    protected $pub_key;
    protected $priv_key;
    protected $ip;
    protected $subsystem;
    protected $self_subsystem;

    public function __construct($uuid, $user, $ip, $port, $pub_key, $priv_key)
    {
        $this->ip = $ip;
        $this->user = $user;
        $this->uuid = $uuid;
        $this->pub_key = $pub_key;
        $this->priv_key = $priv_key;
        $this->port = $port;

        $this->setup();
    }

    private function setup(){
        Storage::put($this->uuid . '-public', $this->pub_key);
        Storage::put($this->uuid . '-private', $this->priv_key);

        $ssh_config = new Configuration($this->ip, $this->port);
        $ssh_auth = new PublicKeyFile($this->user, Storage::disk('local')->path($this->uuid . '-public'), Storage::disk('local')->path($this->uuid . '-private'), '');
        $session = new Session($ssh_config, $ssh_auth);
        $this->subsystem = $session->getExec();
        $this->self_subsystem = new SSHExec($session);
    }

    public function isOnline()
    {
        try
        {
            $this->subsystem->getResource();
            return true;
        }
        catch(\ErrorException $e)
        {
            return false;
        }
    }

    public function command($data)
    {

        try {
            //if(Str::contains($data, 'nohup'))
            //{
            //    return $this->self_subsystem->run($data);
            //}
            return $this->subsystem->run($data);
        }
        catch(\RuntimeException $e)
        {
            return false;
        }
    }


}
