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
    protected $subsystem_exec;
    protected $subsystem_sftp;
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
        $this->subsystem_exec = $session->getExec();
        $this->subsystem_sftp = $session->getSftp();
        $this->self_subsystem = new SSHExec($session);
    }

    public function isOnline()
    {
        try
        {
            $res = $this->subsystem_exec->getResource();
            //print($res);
            return true;
        }
        catch(\ErrorException $e)
        {
            //print('shit');
            return false;
        }
    }

    public function command($data)
    {

        try {
            return $this->subsystem_exec->run($data);
        }
        catch(\RuntimeException $e)
        {
            return false;
        }
    }

    public function read_file($file_name)
    {

        try {
            return $this->subsystem_sftp->read($file_name);
        }
        catch(\RuntimeException $e)
        {
            return false;
        }
    }


}
