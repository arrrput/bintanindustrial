<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        Testimonial::create([
            'name' => 'Robert Halim',
            'position' => 'Managing Director, PT Nexcon Industries',
            'description' => "Bintan Industrial Estate gave us a hassle-free start. The ready-built factory and one-stop licensing support meant we were operational within months instead of years.",
            'stars' => 5,
        ]);

        Testimonial::create([
            'name' => 'Grace Anastasia',
            'position' => 'Supply Chain Manager, PT Vantera Manufacturing',
            'description' => "The proximity to Singapore combined with the estate's reliable infrastructure has been a huge advantage for our logistics and export operations.",
            'stars' => 5,
        ]);

        Testimonial::create([
            'name' => 'Bambang Setiawan',
            'position' => 'Factory Manager, PT Kartika Prima',
            'description' => "The management team is responsive and genuinely invested in helping tenants succeed. Any facility issue we raise gets resolved quickly.",
            'stars' => 4,
        ]);

        Testimonial::create([
            'name' => 'Michelle Tanaka',
            'position' => 'HR & GA Director, PT Orinoco Electronics',
            'description' => "Having worker housing, recreational facilities and the town centre all within the estate makes it much easier for us to attract and retain talent.",
            'stars' => 5,
        ]);

        Testimonial::create([
            'name' => 'Hendra Wijaya',
            'position' => 'Plant Manager, PT Meridian Precision',
            'description' => "We evaluated several industrial parks in the region before choosing Bintan. The combination of cost efficiency and quality infrastructure was unmatched.",
            'stars' => 5,
        ]);
    }
}
