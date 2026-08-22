<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        Program::create([
            'title' => 'ANNUAL TENANT GATHERING',
            'subtitle' => '"Bringing our community of tenants and partners together."',
            'description' => "Each year, Bintan Industrial Estate hosts gatherings and celebrations that bring together tenants, employees and partners across the estate. From cultural festivities to milestone celebrations, these events strengthen the sense of community within our self-contained industrial township.\n\nThese occasions are also an opportunity to recognize the contributions of our tenants and workforce, reinforcing the collaborative spirit that has helped BIE grow into a thriving industrial hub.",
            'image' => 'program/image8.jpeg',
            'category' => 'event',
            'order' => 1
        ]);

        Program::create([
            'title' => 'RESORT-STYLE ENTERTAINMENT',
            'subtitle' => null,
            'description' => "The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.\n\nFrom sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, tenants and employees of Bintan Industrial Estate can unwind in the relaxing embrace of the resorts just minutes away.",
            'image' => 'program/image9.jpeg',
            'category' => 'entertainment',
            'order' => 1
        ]);

        Program::create([
            'title' => 'CORPORATE SOCIAL RESPONSIBILITY',
            'subtitle' => '"Giving back to the community and environment we grow in."',
            'description' => "Bintan Industrial Estate is committed to supporting the local community through education, environmental sustainability and social welfare initiatives. Our CSR programs include scholarship support for local students, environmental conservation efforts and partnerships with nearby villages.\n\nWe believe that sustainable business growth goes hand in hand with the wellbeing of the communities and environment surrounding our estate.",
            'image' => 'program/image10.jpeg',
            'category' => 'csr',
            'order' => 1
        ]);
    }
}
