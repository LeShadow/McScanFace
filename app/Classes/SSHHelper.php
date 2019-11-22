<?php
namespace App\Classes;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;
use phpseclib\Net\SFTP;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Log;
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
    protected $key;
    protected $ssh;
    protected $online = false;
    public function __construct($uuid, $user, $ip, $port, $pub_key, $priv_key, $type = 'SSH2')
    {
        $this->ip = $ip;
        $this->user = $user;
        $this->uuid = $uuid;
        $this->pub_key = $pub_key;
        $this->priv_key = $priv_key;
        $this->port = $port;

        $this->setup($type);
    }

    private function setup($type){
        if($type === 'SSH2'){
            $this->ssh = new SSH2($this->ip, $this->port);
        }
        else
        {
            $this->ssh = new SFTP($this->ip, $this->port);
        }
        $this->key = new RSA();
        $this->key->loadKey($this->priv_key);
        $this->ssh->sendIdentificationStringLast();
        if($this->ssh->login($this->user, $this->key)) {
            $this->online = true;
        }

    }

    public function isOnline()
    {
        try {

            if($this->online)
            {
                return true;
            }

        }
        catch(\ErrorException $e) {
            dd($this->ssh->getLog());
            return false;
        }
    }

    public function command($data)
    {

        //$this->ssh->login($this->user, $this->key);
        try {
            return $this->ssh->exec($data);
        }
        catch(\ErrorException $e)
        {
            dd($this->ssh->getLog());
            return false;
        }
    }

    public function read_file($file_name)
    {

        try {
            $file_content = $this->ssh->get($file_name);
            Log::debug($file_content);
            Log::debug($this->ssh->getLog());
            return $this->ssh->get($file_name);
        }
        catch(\ErrorException $e)
        {
            dd($e);
            return false;
        }
    }

    public function getDirs() {
        try {
            return $this->ssh->rawList();
        }        catch(\ErrorException $e)
        {
            dd($e);
            return false;
        }
    }


}
