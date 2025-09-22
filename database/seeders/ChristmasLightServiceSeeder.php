<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Support\Str;

class ChristmasLightServiceSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::create([
            'name' => 'Christmas Light Installation',
            'slug' => 'christmas-light-installation',
            'short_description' => 'Professional Christmas light installation services throughout DFW. Transform your home into a magical holiday showcase with commercial-grade LED lights, expert design, and complete seasonal maintenance.',
            'description' => '<p>Be the house everyone slows down to see this Christmas! Our professional Christmas light installation service transforms ordinary homes into extraordinary holiday showcases throughout the Dallas-Fort Worth area.</p>

<h3>Why Choose Professional Christmas Light Installation?</h3>
<p>Professional installation delivers stunning visual impact with commercial-grade LED lights that shine 40% brighter and last 10 times longer than store-bought alternatives. Our expert crews handle everything from design to removal, giving you more time to enjoy the holidays with family.</p>

<h3>Complete Christmas Light Services</h3>
<ul>
<li><strong>Custom Design:</strong> Free consultation to create your perfect holiday display</li>
<li><strong>Professional Installation:</strong> Expert crews complete most homes in one day</li>
<li><strong>Commercial-Grade LEDs:</strong> Brighter, longer-lasting, energy-efficient lights</li>
<li><strong>Season-Long Support:</strong> 48-hour maintenance guarantee all season</li>
<li><strong>Complete Removal:</strong> Professional takedown after the holidays</li>
<li><strong>Climate Storage:</strong> Your lights stored safely until next year</li>
</ul>

<h3>Service Areas</h3>
<p>Creating Christmas magic throughout DFW including Highland Park, University Park, Southlake, Westlake, Plano, Frisco, Allen, McKinney, and surrounding communities.</p>

<h3>Book Early for Best Dates</h3>
<p>Our installation calendar fills quickly. August and September bookings receive priority scheduling and special pricing. Don\'t wait for the December rush - secure your date today!</p>',
            'is_active' => true,
            'order_index' => 9,
            'meta_title' => 'Christmas Light Installation DFW | Professional Holiday Lighting',
            'meta_description' => 'Professional Christmas light installation in Dallas-Fort Worth. Commercial-grade LED lights, expert design, full-season maintenance. Book early for best dates!',
        ]);

        $this->command->info('Christmas Light Installation service created successfully.');
    }
}