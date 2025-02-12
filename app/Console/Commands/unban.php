<?php

namespace App\Console\Commands;

use App\FirewallIp;
use Illuminate\Console\Command;

class unban extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unban {ip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'débannir un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(!filter_var($this->argument('ip'), FILTER_VALIDATE_IP)) {
            $this->error('L\'adresse IP ' . $this->argument('ip') . ' n\'est pas valide.');
            return;
        }

        $ip = $this->argument('ip');
        FirewallIp::where('ip', $ip)->delete();
        $this->info('L\'adresse IP ' . $ip . ' a été débannie.');
    }
}
