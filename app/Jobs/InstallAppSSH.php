<?php

namespace App\Jobs;

use phpseclib3\Net\SSH2;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class InstallAppSSH implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server;
    protected $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($server, $site)
    {
        $this->server   = $server;
        $this->site     = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ssh = new SSH2($this->server->ip, 22);
        $ssh->login('cipi', $this->server->password);
        $ssh->setTimeout(360);
        $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo unlink installapp');
        $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo wget ' . config('app.url') . '/sh/installapp');
        $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo dos2unix installapp');
        $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo bash installapp -u ' . $this->site->username . ' -dbp ' . $this->site->database . ' -b ' . $this->site->basepath);
        $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo unlink installapp');
        $ssh->exec('exit');

        // $fullpath = '/home/' . $this->site->username . '/web' . $this->site->basepath ? '/' . $this->site->basepath : '';
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo wget -P /home/' . $this->site->username . ' https://wordpress.org/latest.zip');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo unzip /home/' . $this->site->username . '/latest.zip ' . $fullpath);
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo mv /home/' . $this->site->username . '/wordpress/* ' . $fullpath);
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo rm -Rf /home/' . $this->site->username . '/wordpress');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sudo cp ' . $fullpath . '/wp-config-sample.php ' . $fullpath . '/wp-config.php');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sed -i "s/database_name_here/' . $this->site->username . '/g" ' . $fullpath . '/wp-config.php');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sed -i "s/username_here/' . $this->site->username . '/g" ' . $fullpath . '/wp-config.php');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S sed -i "s/password_here/' . $this->site->database . '/g" ' . $fullpath . '/wp-config.php');
        // $ssh->exec('echo ' . $this->server->password . ' | sudo -S curl -k https://api.wordpress.org/secret-key/1.1/salt/ >> ' . $fullpath . '/wp-config.php');
    }
}
