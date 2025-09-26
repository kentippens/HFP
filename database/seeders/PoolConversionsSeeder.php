<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Silo;

class PoolConversionsSeeder extends Seeder
{
    public function run()
    {
        Silo::updateOrCreate(
            ['slug' => 'pool-conversions'],
            [
                'name' => 'Pool Conversions',
                'template' => 'pool-conversions',
                'meta_title' => 'Pool Conversions | Transform to Fiberglass | 25-Year Warranty',
                'meta_description' => 'Convert your traditional pool to fiberglass. No excavation. 5-7 day installation. North & Central Texas exclusive Fibre Tech dealer. Free quote.',
                'meta_robots' => 'index, follow',
                'canonical_url' => url('/pool-conversions'),
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Pool Conversions to Fiberglass',
                    'description' => 'Professional pool conversion services to transform traditional pools to fiberglass with 25-year warranty',
                    'provider' => [
                        '@type' => 'LocalBusiness',
                        'name' => 'Hexagon Fiberglass Pools',
                        'telephone' => '972-789-2983',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'addressLocality' => 'Dallas',
                            'addressRegion' => 'TX',
                            'addressCountry' => 'US'
                        ]
                    ],
                    'areaServed' => [
                        '@type' => 'State',
                        'name' => 'Texas'
                    ],
                    'serviceType' => 'Pool Conversion',
                    'url' => url('/pool-conversions')
                ]),
                'content' => null,
                'is_active' => true,
                'sort_order' => 2
            ]
        );
    }
}