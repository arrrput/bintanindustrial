<?php

namespace Database\Seeders;

use App\Models\Bintan;
use Illuminate\Database\Seeder;

class BintanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        Bintan::truncate();

        // 1. Slider: A WORLD OF POSSIBILITIES (Default Style)
        Bintan::create([
            'title' => 'A WORLD OF POSSIBILITIES',
            'subtitle' => '"Bintan sits at the crossroads of the future."',
            'description' => 'With Singapore just an hour away, the island offers an unrivalled cost-competitive advantage for companies to plug into global markets.\n\nThis powerful value proposition is bolstered by Bintan’s complete work, live and play culture. The island, a popular leisure destination for visitors near and far, has a pro-business attitude that makes it an ideal and idyllic location to work and play. This is where lifestyle opportunities and business possibilities are blended and balanced, where success is served to those with foresight.',
            'image' => 'Bintan/image2.jpeg',
            'icon' => 'fa-solid fa-earth-asia',
            'layout_style' => 'default',
            'category' => 'main_slider',
            'order' => 1,
        ]);

        // 2. Slider: CONNECTED THINKING (Info Grid Style)
        Bintan::create([
            'title' => 'CONNECTED THINKING',
            'subtitle' => '',
            'description' => '', 
            'image' => 'Bintan/image3.jpeg',
            'icon' => 'fa-solid fa-network-wired',
            'layout_style' => 'info_grid',
            'extra_content' => [
                'glance' => [
                    'title' => 'Batam at a Glance',
                    'items' => [
                        ['icon' => 'fa-solid fa-maximize', 'label' => 'Size', 'value' => '1,030 km²'],
                        ['icon' => 'fa-solid fa-users', 'label' => 'Population', 'value' => '300,000'],
                        ['icon' => 'fa-solid fa-language', 'label' => 'Languages', 'value' => 'Bahasa Indonesia, English'],
                        ['icon' => 'fa-solid fa-temperature-high', 'label' => 'Climate', 'value' => 'Tropical and humid, 24-31°C'],
                        ['icon' => 'fa-solid fa-clock', 'label' => 'Time Zone', 'value' => 'GMT + 7:00, 1 hour behind SG'],
                    ]
                ],
                'distance' => [
                    'title' => 'Distance',
                    'items' => [
                        ['icon' => 'fa-solid fa-ship', 'value' => '50 km, 60 mins by ferry from Singapore to Lobam (BIE)'],
                        ['icon' => 'fa-solid fa-umbrella-beach', 'value' => '45 km, 55 mins by ferry from Singapore to Lagoi'],
                        ['icon' => 'fa-solid fa-ferry', 'value' => '13 km, 25 mins from Batam to Lobam (BIE)'],
                    ]
                ],
                'connectivity' => [
                    'title' => 'Connectivity',
                    'items' => [
                        ['icon' => 'fa-solid fa-anchor', 'label' => 'Sea Connectivity', 'value' => 'Over 10 ferry trips to/from Singapore to Bintan Island each day'],
                        ['icon' => 'fa-solid fa-plane-departure', 'label' => 'Air Connectivity', 'value' => 'Connected via nearby international networks.'],
                    ]
                ]
            ],
            'category' => 'main_slider',
            'order' => 2,
        ]);

        // 3. Slider: DIRECTION OF FUTURE (Advantage Grid Style)
        Bintan::create([
            'title' => 'DIRECTION OF FUTURE',
            'subtitle' => '',
            'description' => 'Bintan’s strong economic promise stems from its favourable business environment, close connectivity to Singapore and the country’s financial network and excellent infrastructure, as well as its abundant workforce and labour cost advantage. Here, every investment dollar has the potential to deliver greater business mileage and sustainable long-term returns for the savvy investor.',
            'image' => 'Bintan/image4.jpeg',
            'icon' => 'fa-solid fa-chart-line',
            'layout_style' => 'advantage_grid',
            'extra_content' => [
                'cards' => [
                    [
                        'title' => 'Free Trade Zone',
                        'description' => '• Import duty exemption on raw materials & equipment\n• Value-Added Tax (VAT) exemption for exporting industries',
                        'icon' => 'fa-solid fa-scale-balanced',
                    ],
                    [
                        'title' => 'Conducive Climate',
                        'description' => '• 100% foreign investment allowed\n• Double Taxation Avoidance with 59 countries (SG, JP, US, EU)\n• Entitled to preferential duty-free entry via GSP COO',
                        'icon' => 'fa-solid fa-handshake-angle',
                    ],
                    [
                        'title' => 'Government Support',
                        'description' => '• Incentives & grants from SG government for SG-based firms\n• Bilateral agreement to promote and protect investments',
                        'icon' => 'fa-solid fa-building-shield',
                    ]
                ]
            ],
            'category' => 'main_slider',
            'order' => 3,
        ]);
    }
}
