<?php

namespace App\Jobs;

use Google\Client;
use Google\Service\Webmasters;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SiteMapGoogle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
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
            Log::info('Sitemap submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error submitting sitemap: ' . $e->getMessage());
        }
    }
}
