<?php

namespace Database\Seeders;

use App\Models\Bie;
use App\Models\Program;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * October 2026 content refresh (English copy, PT Bintan Inti Industrial Estate profile, programs).
 * Matches records by name/title, so it is safe to run more than once and on any environment:
 *
 *   php artisan db:seed --class=ContentRefreshSeeder
 */
class ContentRefreshSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->testimonials();
            $this->industrialEstate();
            $this->bintanSlider();
            $this->programs();
        });
    }

    /** Client testimonials: Indonesian comments translated to English. */
    private function testimonials(): void
    {
        $comments = [
            'Michael Tanuwijaya' => 'Investing in Bintan Industrial Estate was the best decision for our company. Logistics to Singapore are highly efficient, and the licensing process went smoothly from start to finish.',
            'Siti Rahmawati'     => 'A skilled workforce and complete infrastructure have kept our factory operations running without disruption since day one.',
            'David Lim'          => 'The strategic location and the responsive BIIE team have been a great help as we expand our business in the region.',
            'Ahmad Fauzan'       => 'Round-the-clock security and the estate\'s own port facilities add real value, keeping the distribution of our products running smoothly.',
        ];

        foreach ($comments as $name => $description) {
            Testimonial::where('name', $name)->update(['description' => $description]);
        }
    }

    /** Home > Our Industrial Estate: profile of PT Bintan Inti Industrial Estate. */
    private function industrialEstate(): void
    {
        Bie::where('page_group', 'bie')->where('title', 'THE PERFECT HOME BASE')->update([
            'badge'       => 'Manufacturing & Logistics',
            'subtitle'    => 'At the Forefront, From the Seafront — One Location for Global Markets',
            'description' => "PT Bintan Inti Industrial Estate (BIIE) develops and manages Bintan Industrial Estate in Lobam, on the island of Bintan in Indonesia's Riau Islands. A member of Gallant Venture Ltd, a Singapore-listed company within the Salim Group, BIIE offers manufacturers a self-contained, sea-front industrial township just 60 minutes by ferry from Singapore and 25 minutes from Batam.\n\n"
                . "Everything a just-in-time operation needs is on site: a container seaport with international port-of-call status, onsite customs, immigration and quarantine (CIQ) clearance, an exclusive passenger ferry terminal, reliable power and water supplies, ready-built factories and prepared land parcels. Tenants and their employees are supported by worker dormitories, the Bintan Inti Executive Village and a town centre with dining, retail and banking facilities.\n\n"
                . "BIIE is also the first of Indonesia's licensed halal industrial estates to become operational, making it a natural base for companies that serve halal and export markets.",
        ]);
    }

    /** Profile > Bintan Island slider: complete the missing subtitles and descriptions. */
    private function bintanSlider(): void
    {
        $slides = [
            'A WORLD OF POSSIBILITIES' => [
                'subtitle'    => '"Bintan sits at the crossroads of the future."',
                'description' => "With Singapore just an hour away by ferry, Bintan offers an unrivalled cost-competitive advantage for companies looking to plug into global markets.\n\n"
                    . "This powerful value proposition is bolstered by the island's complete work, live and play culture. A popular leisure destination for visitors near and far, Bintan combines a pro-business attitude with a relaxed island lifestyle, making it an ideal location to build, grow and enjoy. Here, lifestyle and business opportunities are blended and balanced, and success is served to those with foresight.",
            ],
            'CONNECTED THINKING' => [
                'subtitle'    => '"Closer to Singapore than you think."',
                'description' => "Bintan is the largest island in Indonesia's Riau Islands province, lying just south of Singapore across the Singapore Strait. Regular ferry services connect Bintan Industrial Estate at Lobam with Singapore and Batam, putting the estate within easy reach of one of the world's busiest ports and its global shipping and airline networks.\n\n"
                    . "Sharing a time zone just one hour behind Singapore and an English-speaking business community, Bintan lets companies run their operations as a seamless extension of their Singapore headquarters.",
            ],
            'DIRECTION OF FUTURE' => [
                'subtitle'    => '"Where every investment goes further."',
                'description' => "Bintan's strong economic promise stems from its favourable business environment, close connectivity to Singapore and its financial network, excellent infrastructure, and an abundant workforce with a labour cost advantage.\n\n"
                    . "As a Free Trade Zone backed by government support on both sides of the strait, Bintan gives every investment dollar the potential to deliver greater business mileage and sustainable long-term returns for the savvy investor.",
            ],
        ];

        foreach ($slides as $title => $data) {
            Bie::where('page_group', 'bintan')->where('title', $title)->update($data);
        }
    }

    /**
     * News > Beyond The Workplace: only the three recurring programs remain.
     * Covers reuse existing brochure images until real event photos are uploaded via the CMS.
     */
    private function programs(): void
    {
        $programs = [
            [
                'title'       => 'ANNUAL GAMES',
                'subtitle'    => '"Friendly competition that brings the whole estate together."',
                'description' => "Every year, Bintan Industrial Estate hosts the Annual Games, bringing tenants and their employees together for a season of friendly sports and traditional games. Teams from companies across the estate compete side by side, building friendships that go beyond the workplace.\n\n"
                    . "More than a competition, the Annual Games celebrate the community spirit of our self-contained industrial township and the people who make it thrive.",
                'image'       => 'program/image8.jpeg',
                'category'    => 'entertainment',
                'order'       => 1,
            ],
            [
                'title'       => 'INDUSTRIAL VISIT',
                'subtitle'    => '"Opening our doors to the next generation of industry."',
                'description' => "Bintan Industrial Estate regularly welcomes industrial visits from universities, vocational schools, government agencies and business delegations. Visitors see first-hand how a self-contained industrial estate operates, from its seaport and ferry terminal to the factories of our tenants.\n\n"
                    . "These visits help connect education with industry, inspire future talent, and introduce prospective investors to the advantages of doing business in Bintan.",
                'image'       => 'program/image1.jpeg',
                'category'    => 'event',
                'order'       => 1,
            ],
            [
                'title'       => 'ANNUAL ORPHANAGE CHARITY',
                'subtitle'    => '"Giving back to the community we grow in."',
                'description' => "Every year, Bintan Industrial Estate and its tenants visit orphanages in the communities around the estate to share donations, school supplies and daily necessities with the children and their caretakers.\n\n"
                    . "This annual charity programme is one of the ways we give back to the people of Bintan, because we believe sustainable business growth goes hand in hand with the wellbeing of the community around us.",
                'image'       => 'program/villa.webp',
                'category'    => 'csr',
                'order'       => 1,
            ],
        ];

        $keep = [];
        foreach ($programs as $data) {
            $keep[] = Program::updateOrCreate(['title' => $data['title']], $data)->id;
        }

        // Take out every other program (their cover files are left on disk; covers above reuse them)
        Program::whereNotIn('id', $keep)->delete();
    }
}
