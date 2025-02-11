<?php

namespace App\Console\Commands;

use Google\Client;
use Google\Service\Webmasters;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-site-map';

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
        $client = new Client();
        $client->setApplicationName('jdgenest.site');
        $client->setScopes(['https://www.googleapis.com/auth/webmasters']);
        $client->setAuthConfig(storage_path('app/google/credential.json'));
        $client->setAccessType('offline');
        $service = new Webmasters($client);

        $baseUrl = url('/');
        $sitemapUrl = $baseUrl . '/sitemap.xml';

        try {
            $service->sitemaps->submit($baseUrl, $sitemapUrl);
            $this->info('Sitemap submitted successfully.');
        } catch (\Exception $e) {
            $this->error('Error submitting sitemap: ' . $e->getMessage());
        }

    }
}
