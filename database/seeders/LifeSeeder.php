<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Life;

class LifeSeeder extends Seeder
{
    public function run()
    {
        Life::create([
            'title' => 'LIFE AT WORK',
            'subtitle' => '"A lush, tranquil environment with all modern conveniences."',
            'description' => "As a self-contained development, Bintan Industrial Estate offers full lifestyle facilities from accommodation and amenities to recreational and leisure options. Much thought has been put into ensuring that its tenants enjoy all the modern conveniences while living in a lush, tranquil environment.\n\nWithin Bintan Industrial Estate is the Bintan Inti Executive Village, an exclusive enclave for tenants. Housing options include well-appointed bungalows, studio apartments and modern condominiums, all of which come with full clubhouse facilities, tennis courts and golfing facilities. There are also generous worker dormitories and a bustling town centre with dining options, retail shops, housing, banking facilities and more, located within its premises.",
            'image' => 'life/image8.jpeg', // Path in storage/public
            'category' => 'work',
            'order' => 1
        ]);

        Life::create([
            'title' => 'Resort-Style RELAXATION',
            'subtitle' => null,
            'description' => "The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.\n\nFrom sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, time away from work at Bintan Industrial Estate is best spent in the relaxing embrace of the resorts.",
            'image' => 'life/image9.jpeg', // Path in storage/public
            'category' => 'relaxation',
            'order' => 1
        ]);
    }
}
