<?php

namespace App\Console\Commands;

use App\post;
use App\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a sitemap';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        // creates sitemap with all urls in your website
        $SitemapGenerator = Sitemap::create(config()->get('app.url'));
        foreach( post::all() as $post ) {
            $SitemapGenerator
                ->add( Url::create(route("post", $post->slug))
                    ->setLastModificationDate(Carbon::parse($post->updated_at))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
                );

        }

        foreach( Page::all() as $page ) {
            $SitemapGenerator
                ->add( Url::create(route("page", $page->slug))
                    ->setLastModificationDate(Carbon::parse($page->updated_at))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
                );

        }

        $SitemapGenerator->add( Url::create(route("default",))
            ->setLastModificationDate(Carbon::today())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1)
        );
        $SitemapGenerator->add( Url::create(route("about"))
            ->setLastModificationDate(Carbon::today())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        );
        $SitemapGenerator->add( Url::create(route("contact"))
            ->setLastModificationDate(Carbon::today())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
            ->setPriority(0.3)
        );
        $SitemapGenerator->writeToFile(public_path('sitemap.xml'));
        return Command::SUCCESS;
    }
}
