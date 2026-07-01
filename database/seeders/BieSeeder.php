<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bie;

class BieSeeder extends Seeder
{
    public function run()
    {
        // Section 1: Manufacturing & Logistics
        Bie::create([
            'badge' => 'Manufacturing & Logistics',
            'title' => 'THE PERFECT HOME BASE',
            'subtitle' => 'Just-In-Time Manufacturing, Warehousing and Distribution',
            'description' => "Every factor essential to just-in-time production schedules is taken care of at Bintan Industrial Estate – direct ferry services from Singapore to the doorstep of the industrial estate, daily shipping for containerised, conventional and light-to-heavy cargo to/from Singapore, a ready pool of skilled labour, and reliable power and water supplies.\n\nThe industrial estate also houses a range of ready-built factories that are suitable for warehousing and distribution to Singapore. With a seaport of international port-of-call status and onsite customs clearance facilities, tenants are assured of a smooth flow of raw materials and finished goods in and out of Bintan Industrial Estate.",
            'image' => 'bie/image5.jpeg',
            'category' => 'main_section',
            'order' => 1
        ]);

        // Pillar Cards
        Bie::create([
            'title' => 'Food Processing',
            'description' => "With increased global attention around food security and diversity, food processing businesses based in Bintan Industrial Estate enjoy an enviable host of benefits including proximity to Singapore and its export connectivity to global markets as well as excellent logistics and supply chain capabilities. Raw materials are also readily available from regional sectors.",
            'icon' => 'fa-solid fa-wheat-awn',
            'category' => 'pillar_card',
            'order' => 1
        ]);

        Bie::create([
            'title' => 'Offshore Marine Services',
            'description' => "Bintan Industrial Estate is developing an Offshore Marine Centre envisioned to be a world-class common-user facility for equipment manufacturers, offshore constructors, drilling contractors, service companies, engineering companies and logistics companies serving the global marine, oil and gas industry. A thriving ecosystem for collective growth.",
            'icon' => 'fa-solid fa-ship',
            'category' => 'pillar_card',
            'order' => 2
        ]);

        Bie::create([
            'title' => 'Aviation MRO Services',
            'description' => "As part of the planned 177-hectare Bintan Aerospace Industry Park located within Bintan Industrial Estate, an Aircraft Maintenance Centre will be dedicated to the maintenance, repair and overhaul of aircraft and components, manufacturing, assembly, aviation training and education as well as industry research.",
            'icon' => 'fa-solid fa-plane-up',
            'category' => 'pillar_card',
            'order' => 3
        ]);

        // Section 2: Strategic Expansion
        Bie::create([
            'badge' => 'Strategic Expansion',
            'title' => 'SAILING TO WIN',
            'description' => "Spanning 270 hectares, Bintan Industrial Estate is a rare sea-fronting industrial estate with up to 4,000 hectares of expansion potential.\n\nWithin its premises, tenants enjoy access to a container port with international port-of-call status, dedicated customs, immigration and quarantine (CIQ) facilities as well as an exclusive passenger ferry terminal. These translate into secure, smooth and timely facilitation of freight shipments.",
            'image' => 'bie/image10.jpeg',
            'category' => 'main_section',
            'order' => 2
        ]);

        // Feature List (Bullet points for Section 2)
        Bie::create([
            'title' => 'Infrastructure',
            'description' => 'Dedicated container port & CIQ facilities',
            'icon' => 'fa-solid fa-circle-nodes',
            'category' => 'feature_list',
            'order' => 1
        ]);

        Bie::create([
            'title' => 'Connectivity',
            'description' => 'Exclusive passenger ferry terminal',
            'icon' => 'fa-solid fa-bolt',
            'category' => 'feature_list',
            'order' => 2
        ]);

        Bie::create([
            'title' => 'Operations',
            'description' => 'Secure and timely freight shipment facilitation',
            'icon' => 'fa-solid fa-circle-check',
            'category' => 'feature_list',
            'order' => 3
        ]);
    }
}
