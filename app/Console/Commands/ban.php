<?php

namespace App\Console\Commands;

use App\FirewallIp;
use App\Repository\FireWallRepository;
use Illuminate\Console\Command;

class ban extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ban {ip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        FireWallRepository::createReport($ip,2, 'ban manuel');
        $this->info('L\'adresse IP ' . $ip . ' a été bannie.');
    }
}
