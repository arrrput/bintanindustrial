<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Work;

class WorkSeeder extends Seeder
{
    public function run()
    {
        // Main Sections
        Work::create([
            'title' => 'Prepared LAND PARCELS',
            'subtitle' => null,
            'description' => "Bintan Industrial Estate is an excellent choice for businesses that require large land parcels. For companies that prefer to build their own facilities from the ground up, the estate has prepared land parcels and all necessary utility services to help tenants optimise their time and cost investment.",
            'image' => 'work/image6.jpeg',
            'category' => 'main_section',
            'order' => 1
        ]);

        Work::create([
            'title' => 'Ready Built FACTORIES',
            'subtitle' => '"All are designed for fast start-up with minimal fitting-out and low upfront capital requirements."',
            'description' => "Bintan Industrial Estate offers a collection of ready-built factories in pristine move-in condition. With three factory types, all of high quality building specifications, companies have the freedom to choose one that best meets their business needs.",
            'image' => 'work/image7.jpeg',
            'category' => 'main_section',
            'order' => 2
        ]);

        // Service Suite
        Work::create([
            'title' => 'Logistics Management',
            'description' => "Bintan Industrial Estate offers efficient sea freight services with a dedicated customs office. Regent Group is a dedicated logistics provider serving tenants with reliable shipping and warehousing services.",
            'icon' => 'fa-solid fa-ship',
            'category' => 'service_suite',
            'order' => 1
        ]);

        Work::create([
            'title' => 'Security and Maintenance',
            'description' => "Safeguarding people and property is Bintan Industrial Estate’s topmost priority. Its professional security team delivers peace of mind by patrolling the premises around the clock.",
            'icon' => 'fa-solid fa-user-shield',
            'category' => 'service_suite',
            'order' => 2
        ]);

        Work::create([
            'title' => 'Manpower Management',
            'description' => "PT Tunaskarya Indoswasta, a manpower recruitment company located at BIE, helps companies secure skilled and trained workers in a cost-competitive manner.",
            'icon' => 'fa-solid fa-users-gear',
            'category' => 'service_suite',
            'order' => 3
        ]);

        Work::create([
            'title' => 'Business Licence Application',
            'description' => "Doing business in Bintan is a simple process with our consultants ready to assist on matters including business licence and permit applications.",
            'icon' => 'fa-solid fa-file-signature',
            'category' => 'service_suite',
            'order' => 4
        ]);

        Work::create([
            'title' => 'Immigration Clearance',
            'description' => "With an exclusive ferry terminal onsite, BIE supports tenants with speedy immigration clearance, work permits and visa applications.",
            'icon' => 'fa-solid fa-passport',
            'category' => 'service_suite',
            'order' => 5
        ]);
    }
}
