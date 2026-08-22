<?php

namespace Database\Seeders;

use App\Models\Bie;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Program;
use App\Models\SectionSetting;
use App\Models\TenantLogo;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Fills every public page (Home, BIE, Bintan Island, Facilities, Program,
 * Careers, Blog) with realistic dummy content for local testing, reusing
 * images already available under public/assets/img.
 */
class DemoContentSeeder extends Seeder
{
    public function run()
    {
        Bie::truncate();
        Program::truncate();
        Career::query()->delete();
        Blog::truncate();
        Testimonial::truncate();
        TenantLogo::truncate();
        SectionSetting::truncate();

        $this->seedSectionSettings();
        $this->seedBie();
        $this->seedWork();
        $this->seedBintan();
        $this->seedPrograms();
        $this->seedCareers();
        $this->seedBlogs();
        $this->seedTestimonials();
        $this->seedTenantLogos();
    }

    private function seedSectionSettings(): void
    {
        SectionSetting::create([
            'section_key' => 'bie',
            'title' => 'Our Industrial Estate',
            'background_images' => [$this->img('Bintan/bie.jpg', 'section_settings')],
        ]);

        SectionSetting::create([
            'section_key' => 'work',
            'title' => 'Facilities',
            'background_images' => [$this->img('Bintan/work.jpg', 'section_settings')],
        ]);

        SectionSetting::create([
            'section_key' => 'bintan',
            'title' => 'Bintan Island',
            'background_images' => [$this->img('Bintan/bintan.jpg', 'section_settings')],
        ]);

        SectionSetting::create([
            'section_key' => 'program',
            'title' => 'Programs at BIE',
            'background_images' => [$this->img('Bintan/villa.webp', 'section_settings')],
        ]);

        SectionSetting::create([
            'section_key' => 'career',
            'title' => 'Careers',
            'background_images' => [$this->img('Bintan/condo.jpg', 'section_settings')],
        ]);

        SectionSetting::create([
            'section_key' => 'blog',
            'title' => 'News & Media',
            'background_images' => [$this->img('bgtenant.jpg', 'section_settings')],
        ]);
    }

    private function seedBie(): void
    {
        Bie::create([
            'page_group' => 'bie',
            'category' => 'main_section',
            'order' => 1,
            'badge' => 'Manufacturing & Logistics',
            'title' => 'THE PERFECT HOME BASE',
            'subtitle' => 'Just-In-Time Manufacturing, Warehousing and Distribution',
            'description' => "Every factor essential to just-in-time production schedules is taken care of at Bintan Industrial Estate – direct ferry services from Singapore to the doorstep of the industrial estate, daily shipping for containerised, conventional and light-to-heavy cargo to/from Singapore, a ready pool of skilled labour, and reliable power and water supplies.\n\nThe industrial estate also houses a range of ready-built factories that are suitable for warehousing and distribution to Singapore. With a seaport of international port-of-call status and onsite customs clearance facilities, tenants are assured of a smooth flow of raw materials and finished goods in and out of Bintan Industrial Estate.",
            'image' => $this->img('Bintan/image5.jpeg', 'bie'),
        ]);

        Bie::create([
            'page_group' => 'bie',
            'category' => 'main_section',
            'order' => 2,
            'badge' => 'Strategic Expansion',
            'title' => 'SAILING TO WIN',
            'description' => "Spanning 270 hectares, Bintan Industrial Estate is a rare sea-fronting industrial estate with up to 4,000 hectares of expansion potential.\n\nWithin its premises, tenants enjoy access to a container port with international port-of-call status, dedicated customs, immigration and quarantine (CIQ) facilities as well as an exclusive passenger ferry terminal. These translate into secure, smooth and timely facilitation of freight shipments.",
            'image' => $this->img('Bintan/image10.jpeg', 'bie'),
        ]);
    }

    private function seedWork(): void
    {
        Bie::create([
            'page_group' => 'work',
            'category' => 'main_section',
            'order' => 1,
            'title' => 'Prepared LAND PARCELS',
            'description' => 'Bintan Industrial Estate is an excellent choice for businesses that require large land parcels. For companies that prefer to build their own facilities from the ground up, the estate has prepared land parcels and all necessary utility services to help tenants optimise their time and cost investment.',
            'image' => $this->img('Bintan/image6.jpeg', 'work'),
        ]);

        Bie::create([
            'page_group' => 'work',
            'category' => 'main_section',
            'order' => 2,
            'title' => 'Ready Built FACTORIES',
            'subtitle' => '"All are designed for fast start-up with minimal fitting-out and low upfront capital requirements."',
            'description' => 'Bintan Industrial Estate offers a collection of ready-built factories in pristine move-in condition. With three factory types, all of high quality building specifications, companies have the freedom to choose one that best meets their business needs.',
            'image' => $this->img('Bintan/image7.jpeg', 'work'),
        ]);

        $serviceSuite = [
            ['title' => 'Logistic Management', 'icon' => 'fa-solid fa-ship', 'description' => 'Bintan Industrial Estate offers efficient sea freight services with a dedicated customs office. This is located at its own onsite container seaport, which has been recognised with international port-of-call status.'],
            ['title' => 'Security And Maintenance', 'icon' => 'fa-solid fa-user-shield', 'description' => "Safeguarding people and property is Bintan Industrial Estate's topmost priority. Its professional security team delivers peace of mind by patrolling the premises around the clock so that everything that is important to its tenants."],
            ['title' => 'Manpower Management', 'icon' => 'fa-solid fa-users-gear', 'description' => "PT Tunaskarya Indoswasta, a manpower recruitment company located at Bintan Industrial Estate, helps companies tap into Indonesia's vast population to secure skilled and trained workers in a cost-competitive manner."],
            ['title' => 'Bussiness License Application', 'icon' => 'fa-solid fa-file-signature', 'description' => "Doing business in Bintan is a simple process with Bintan Industrial Estate's team of consultants ready to advise and assist companies on start-up matters including business licence and permit applications."],
            ['title' => 'Imigration Clearance', 'icon' => 'fa-solid fa-passport', 'description' => 'With an exclusive passenger ferry terminal located onsite, Bintan Industrial Estate supports its tenants with speedy immigration clearance as well as work permit and multi-business visa applications.'],
        ];

        foreach ($serviceSuite as $i => $item) {
            Bie::create([
                'page_group' => 'work',
                'category' => 'service_suite',
                'order' => $i + 1,
                'title' => $item['title'],
                'icon' => $item['icon'],
                'description' => $item['description'],
            ]);
        }
    }

    private function seedBintan(): void
    {
        Bie::create([
            'page_group' => 'bintan',
            'category' => 'main_slider',
            'order' => 1,
            'layout_style' => 'default',
            'icon' => 'fa-solid fa-earth-asia',
            'title' => 'A WORLD OF POSSIBILITIES',
            'subtitle' => '"Bintan sits at the crossroads of the future."',
            'description' => "With Singapore just an hour away, the island offers an unrivalled cost-competitive advantage for companies to plug into global markets.\n\nThis powerful value proposition is bolstered by Bintan's complete work, live and play culture. The island, a popular leisure destination for visitors near and far, has a pro-business attitude that makes it an ideal and idyllic location to work and play. This is where lifestyle opportunities and business possibilities are blended and balanced, where success is served to those with foresight.",
            'image' => $this->img('Bintan/image2.jpeg', 'bintan'),
        ]);

        Bie::create([
            'page_group' => 'bintan',
            'category' => 'main_slider',
            'order' => 2,
            'layout_style' => 'info_grid',
            'icon' => 'fa-solid fa-network-wired',
            'title' => 'CONNECTED THINKING',
            'image' => $this->img('Bintan/image3.jpeg', 'bintan'),
            'extra_content' => [
                'glance' => [
                    'title' => 'Bintan at a Glance',
                    'items' => [
                        ['icon' => 'fa-solid fa-maximize', 'label' => 'Size', 'value' => '1,946 km²'],
                        ['icon' => 'fa-solid fa-users', 'label' => 'Population', 'value' => '300,000'],
                        ['icon' => 'fa-solid fa-language', 'label' => 'Languages', 'value' => 'Bahasa Indonesia, English'],
                        ['icon' => 'fa-solid fa-temperature-high', 'label' => 'Climate', 'value' => 'Tropical and humid, 24-31°C'],
                        ['icon' => 'fa-solid fa-clock', 'label' => 'Time Zone', 'value' => 'GMT + 7:00, 1 hour behind SG'],
                    ],
                ],
                'distance' => [
                    'title' => 'Distance',
                    'items' => [
                        ['icon' => 'fa-solid fa-ship', 'value' => '50 km, 60 mins by ferry from Singapore to Lobam (BIE)'],
                        ['icon' => 'fa-solid fa-umbrella-beach', 'value' => '45 km, 55 mins by ferry from Singapore to Lagoi'],
                        ['icon' => 'fa-solid fa-ferry', 'value' => '13 km, 25 mins from Batam to Lobam (BIE)'],
                    ],
                ],
            ],
        ]);

        Bie::create([
            'page_group' => 'bintan',
            'category' => 'main_slider',
            'order' => 3,
            'layout_style' => 'advantage_grid',
            'icon' => 'fa-solid fa-chart-line',
            'title' => 'DIRECTION OF FUTURE',
            'description' => "Bintan's strong economic promise stems from its favourable business environment, close connectivity to Singapore and the country's financial network and excellent infrastructure, as well as its abundant workforce and labour cost advantage. Here, every investment dollar has the potential to deliver greater business mileage and sustainable long-term returns for the savvy investor.",
            'image' => $this->img('Bintan/image4.jpeg', 'bintan'),
            'extra_content' => [
                'cards' => [
                    ['title' => 'Free Trade Zone', 'icon' => 'fa-solid fa-scale-balanced', 'description' => "• Import duty exemption on raw materials & equipment\n• Value-Added Tax (VAT) exemption for exporting industries"],
                    ['title' => 'Conducive Climate', 'icon' => 'fa-solid fa-handshake-angle', 'description' => "• 100% foreign investment allowed\n• Double Taxation Avoidance with 59 countries (SG, JP, US, EU)\n• Entitled to preferential duty-free entry via GSP COO"],
                    ['title' => 'Government Support', 'icon' => 'fa-solid fa-building-shield', 'description' => "• Incentives & grants from SG government for SG-based firms\n• Bilateral agreement to promote and protect investments"],
                ],
            ],
        ]);
    }

    private function seedPrograms(): void
    {
        Program::create([
            'title' => 'ANNUAL TENANT GATHERING',
            'subtitle' => '"Bringing our community of tenants and partners together."',
            'description' => "Each year, Bintan Industrial Estate hosts gatherings and celebrations that bring together tenants, employees and partners across the estate. From cultural festivities to milestone celebrations, these events strengthen the sense of community within our self-contained industrial township.\n\nThese occasions are also an opportunity to recognize the contributions of our tenants and workforce, reinforcing the collaborative spirit that has helped BIE grow into a thriving industrial hub.",
            'image' => $this->img('Bintan/image8.jpeg', 'program'),
            'category' => 'event',
            'order' => 1,
        ]);

        Program::create([
            'title' => 'RESORT-STYLE ENTERTAINMENT',
            'description' => "The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.\n\nFrom sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, tenants and employees of Bintan Industrial Estate can unwind in the relaxing embrace of the resorts just minutes away.",
            'image' => $this->img('Bintan/villa.webp', 'program'),
            'category' => 'entertainment',
            'order' => 1,
        ]);

        Program::create([
            'title' => 'CORPORATE SOCIAL RESPONSIBILITY',
            'subtitle' => '"Giving back to the community and environment we grow in."',
            'description' => "Bintan Industrial Estate is committed to supporting the local community through education, environmental sustainability and social welfare initiatives. Our CSR programs include scholarship support for local students, environmental conservation efforts and partnerships with nearby villages.\n\nWe believe that sustainable business growth goes hand in hand with the wellbeing of the communities and environment surrounding our estate.",
            'image' => $this->img('Bintan/image1.jpeg', 'program'),
            'category' => 'csr',
            'order' => 1,
        ]);
    }

    private function seedCareers(): void
    {
        $today = now()->toDateString();

        $careers = [
            [
                'title' => 'HR & GA Staff',
                'level' => 'Staff',
                'min_education' => 'D3/S1 Semua Jurusan',
                'min_experience' => '1-2 Tahun',
                'description' => 'Bertanggung jawab dalam mendukung operasional Human Resources & General Affairs di lingkungan Bintan Industrial Estate, termasuk administrasi karyawan, rekrutmen, dan pengelolaan fasilitas perusahaan.',
                'requirements' => "- Pendidikan minimal D3/S1 semua jurusan\n- Pengalaman minimal 1-2 tahun di bidang HR/GA\n- Memiliki kemampuan komunikasi dan koordinasi yang baik\n- Mampu bekerja dengan sistem administrasi kepegawaian\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
                'closing_days' => 30,
            ],
            [
                'title' => 'Business Development Executive',
                'level' => 'Staff/Officer',
                'min_education' => 'S1 Bisnis/Manajemen/Teknik',
                'min_experience' => '2-3 Tahun',
                'description' => 'Mengembangkan hubungan dengan calon investor dan tenant baru, serta mendukung strategi pemasaran kawasan industri Bintan Industrial Estate kepada pasar regional dan internasional.',
                'requirements' => "- S1 Bisnis, Manajemen, atau Teknik\n- Pengalaman 2-3 tahun di bidang business development/marketing\n- Mampu berbahasa Inggris aktif (lisan & tulisan)\n- Memiliki jaringan/relasi dengan sektor industri menjadi nilai tambah\n- Siap melakukan perjalanan dinas",
                'closing_days' => 45,
            ],
            [
                'title' => 'Security Supervisor',
                'level' => 'Supervisor',
                'min_education' => 'SMA/SMK Sederajat',
                'min_experience' => '3-5 Tahun',
                'description' => 'Mengawasi dan mengoordinasikan tim keamanan dalam menjaga keamanan aset, karyawan, dan tenant di seluruh area Bintan Industrial Estate selama 24 jam.',
                'requirements' => "- Pendidikan minimal SMA/SMK sederajat\n- Pengalaman 3-5 tahun di bidang keamanan, diutamakan pernah menjabat sebagai supervisor\n- Memiliki sertifikasi Gada Pratama/Gada Madya\n- Bersedia bekerja dengan sistem shift\n- Fisik sehat dan disiplin tinggi",
                'closing_days' => 20,
            ],
            [
                'title' => 'Civil Engineer (Maintenance)',
                'level' => 'Staff/Engineer',
                'min_education' => 'S1 Teknik Sipil',
                'min_experience' => '2-4 Tahun',
                'description' => 'Bertanggung jawab atas pemeliharaan infrastruktur, bangunan, dan fasilitas di Bintan Industrial Estate, termasuk perencanaan perbaikan dan pengawasan proyek konstruksi kecil-menengah.',
                'requirements' => "- S1 Teknik Sipil\n- Pengalaman 2-4 tahun di bidang maintenance/konstruksi\n- Memahami penggunaan AutoCAD dan software terkait\n- Mampu bekerja di lapangan dan berkoordinasi dengan kontraktor\n- Teliti dan bertanggung jawab",
                'closing_days' => 60,
            ],
        ];

        foreach ($careers as $c) {
            Career::create([
                'title' => $c['title'],
                'slug' => \Illuminate\Support\Str::slug($c['title']),
                'location' => 'Bintan, Kepulauan Riau',
                'level' => $c['level'],
                'min_education' => $c['min_education'],
                'min_experience' => $c['min_experience'],
                'description' => $c['description'],
                'requirements' => $c['requirements'],
                'status' => 'open',
                'posted_date' => $today,
                'closing_date' => now()->addDays($c['closing_days'])->toDateString(),
                'post_to_linkedin' => false,
            ]);
        }
    }

    private function seedBlogs(): void
    {
        $blogs = [
            [
                'title' => 'Peringatan Bulan K3 Nasional di Bintan Industrial Estate',
                'image' => 'BLOG/BulanK3.jpg',
                'excerpt' => 'Bintan Industrial Estate turut memperingati Bulan Keselamatan dan Kesehatan Kerja (K3) Nasional dengan berbagai kegiatan edukasi dan sosialisasi keselamatan kerja bagi seluruh tenant dan karyawan.',
                'content' => "Sebagai bentuk komitmen terhadap budaya keselamatan kerja, Bintan Industrial Estate menggelar rangkaian kegiatan dalam rangka Bulan Keselamatan dan Kesehatan Kerja (K3) Nasional. Kegiatan ini melibatkan seluruh tenant dan karyawan yang beroperasi di kawasan industri.\n\nRangkaian acara meliputi sosialisasi prosedur keselamatan kerja, simulasi tanggap darurat, hingga pemeriksaan kesehatan gratis. Diharapkan kegiatan ini dapat meningkatkan kesadaran seluruh pihak akan pentingnya menjaga keselamatan di lingkungan kerja.",
            ],
            [
                'title' => 'Aksi Donor Darah Bersama Tenant Bintan Industrial Estate',
                'image' => 'BLOG/DonorD.jpg',
                'excerpt' => 'Kegiatan donor darah rutin digelar sebagai wujud kepedulian sosial Bintan Industrial Estate bersama para tenant terhadap kebutuhan darah di Kepulauan Riau.',
                'content' => "Bintan Industrial Estate bekerja sama dengan Palang Merah Indonesia (PMI) setempat menggelar kegiatan donor darah yang diikuti oleh karyawan dan tenant di kawasan industri. Kegiatan ini merupakan bagian dari program tanggung jawab sosial perusahaan yang rutin dilaksanakan setiap tahun.\n\nAntusiasme peserta cukup tinggi, dengan ratusan kantong darah berhasil terkumpul untuk membantu memenuhi kebutuhan stok darah di Kepulauan Riau.",
            ],
            [
                'title' => 'Peluncuran Masterplan Baru Bintan Industrial Estate',
                'image' => 'BLOG/Masterplan.jpg',
                'excerpt' => 'Bintan Industrial Estate memperkenalkan masterplan pengembangan kawasan terbaru guna mendukung ekspansi bisnis para tenant di masa mendatang.',
                'content' => "Dalam upaya mendukung pertumbuhan investasi, Bintan Industrial Estate resmi meluncurkan masterplan pengembangan kawasan terbaru. Masterplan ini mencakup perluasan area industri, peningkatan infrastruktur pelabuhan, serta penambahan fasilitas pendukung bagi tenant.\n\nPengembangan ini merupakan bagian dari visi jangka panjang untuk menjadikan Bintan Industrial Estate sebagai kawasan industri terdepan di kawasan Asia Tenggara.",
            ],
            [
                'title' => 'Kunjungan Delegasi Mitra Strategis ke Bintan Industrial Estate',
                'image' => 'BLOG/NJCvisit.jpg',
                'excerpt' => 'Delegasi mitra strategis melakukan kunjungan kerja ke Bintan Industrial Estate untuk menjajaki peluang kerja sama dan investasi lebih lanjut.',
                'content' => "Bintan Industrial Estate menerima kunjungan delegasi mitra strategis yang bertujuan untuk melihat langsung fasilitas dan potensi investasi di kawasan industri. Dalam kunjungan tersebut, delegasi diajak berkeliling area pabrik, pelabuhan, serta fasilitas pendukung lainnya.\n\nKunjungan ini diharapkan dapat mempererat hubungan kerja sama serta membuka peluang investasi baru bagi kedua belah pihak.",
            ],
            [
                'title' => 'Kunjungan Wakil Menteri Perdagangan RI ke Bintan Industrial Estate',
                'image' => 'BLOG/wamenperdagangan.jpg',
                'excerpt' => 'Wakil Menteri Perdagangan Republik Indonesia berkunjung ke Bintan Industrial Estate guna meninjau perkembangan investasi dan perdagangan di kawasan.',
                'content' => "Wakil Menteri Perdagangan Republik Indonesia melakukan kunjungan kerja ke Bintan Industrial Estate untuk meninjau langsung perkembangan kawasan industri serta mendengarkan masukan dari para pelaku usaha. Kunjungan ini menjadi bentuk dukungan pemerintah terhadap iklim investasi di Kepulauan Riau.\n\nDalam kesempatan tersebut, dibahas pula berbagai upaya untuk mempermudah proses ekspor-impor bagi tenant yang berlokasi di Bintan Industrial Estate.",
            ],
            [
                'title' => 'Penyambutan Kunjungan CEO Grup Mitra Bisnis',
                'image' => 'BLOG/welcomedCEOm7m12.jpg',
                'excerpt' => 'Manajemen Bintan Industrial Estate menyambut kunjungan CEO dari grup mitra bisnis dalam rangka membahas rencana kolaborasi jangka panjang.',
                'content' => "Manajemen Bintan Industrial Estate menyambut kunjungan CEO dari grup mitra bisnis untuk membahas rencana kolaborasi jangka panjang, termasuk potensi perluasan investasi di kawasan industri. Pertemuan ini juga menjadi ajang diskusi mengenai tren industri terkini serta peluang sinergi antar perusahaan.\n\nKunjungan ini diharapkan menjadi awal dari kerja sama yang saling menguntungkan bagi kedua belah pihak.",
            ],
        ];

        foreach ($blogs as $b) {
            $imagePath = $this->img($b['image'], 'blogs');
            Blog::create([
                'title' => $b['title'],
                'slug' => \Illuminate\Support\Str::slug($b['title']),
                'image' => json_encode([$imagePath]),
                'content' => $b['content'],
                'excerpt' => $b['excerpt'],
                'post_to_ig' => false,
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['name' => 'Michael Tanuwijaya', 'position' => 'Plant Director, PT Centrotec Indonesia', 'stars' => 5, 'description' => 'Berinvestasi di Bintan Industrial Estate adalah keputusan terbaik bagi perusahaan kami. Akses logistik ke Singapura sangat efisien dan proses perizinan berjalan lancar.', 'photo' => 'testimonials/testimonials-1.jpg'],
            ['name' => 'Siti Rahmawati', 'position' => 'HR Manager, PT Bionesia', 'stars' => 5, 'description' => 'Dukungan tenaga kerja terampil dan infrastruktur yang lengkap membuat operasional pabrik kami berjalan tanpa hambatan sejak hari pertama.', 'photo' => 'testimonials/testimonials-2.jpg'],
            ['name' => 'David Lim', 'position' => 'Operations Head, PT AMC', 'stars' => 4, 'description' => 'Lokasi strategis dan pelayanan tim BIE yang responsif sangat membantu ekspansi bisnis kami di kawasan ini.', 'photo' => 'testimonials/testimonials-3.jpg'],
            ['name' => 'Ahmad Fauzan', 'position' => 'General Manager, PT Singatac Indonesia', 'stars' => 5, 'description' => 'Keamanan 24 jam dan fasilitas pelabuhan sendiri menjadi nilai tambah besar bagi kelancaran distribusi produk kami.', 'photo' => 'testimonials/testimonials-4.jpg'],
            ['name' => 'Jennifer Wong', 'position' => 'Finance Director, PT IPEX', 'stars' => 5, 'description' => 'Tim Bintan Industrial Estate sangat profesional dalam membantu proses perizinan usaha dan pengurusan dokumen impor-ekspor.', 'photo' => 'testimonials/testimonials-5.jpg'],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create([
                'name' => $t['name'],
                'position' => $t['position'],
                'description' => $t['description'],
                'stars' => $t['stars'],
                'photo' => $this->img($t['photo'], 'testimonials'),
            ]);
        }
    }

    private function seedTenantLogos(): void
    {
        $tenants = [
            ['file' => 'Tenant-Logo/A&ONE-Logo_Horizontal.png', 'name' => 'A&ONE', 'as' => 'a-one.png'],
            ['file' => 'Tenant-Logo/AMC.png', 'name' => 'AMC', 'as' => 'amc.png'],
            ['file' => 'Tenant-Logo/BOMC.png', 'name' => 'BOMC', 'as' => 'bomc.png'],
            ['file' => 'Tenant-Logo/Bionesia.jpg', 'name' => 'Bionesia', 'as' => 'bionesia.jpg'],
            ['file' => 'Tenant-Logo/CCI.png', 'name' => 'CCI', 'as' => 'cci.png'],
            ['file' => 'Tenant-Logo/CENTROTEC.png', 'name' => 'Centrotec', 'as' => 'centrotec.png'],
            ['file' => 'Tenant-Logo/CMTI.png', 'name' => 'CMTI', 'as' => 'cmti.png'],
            ['file' => 'Tenant-Logo/IPEX.png', 'name' => 'IPEX', 'as' => 'ipex.png'],
            ['file' => 'Tenant-Logo/ISPC.png', 'name' => 'ISPC', 'as' => 'ispc.png'],
            ['file' => 'Tenant-Logo/Logo OK ESCO.png', 'name' => 'OK ESCO', 'as' => 'ok-esco.png'],
            ['file' => 'Tenant-Logo/Logo-IGCL-corporate-putih-baru-01.png', 'name' => 'IGCL', 'as' => 'igcl.png'],
            ['file' => 'Tenant-Logo/MAJAPAHIT SABUDRA JAYA.png', 'name' => 'Majapahit Sabudra Jaya', 'as' => 'majapahit-sabudra-jaya.png'],
            ['file' => 'Tenant-Logo/Peperl+Fuchs.png', 'name' => 'Pepperl+Fuchs', 'as' => 'pepperl-fuchs.png'],
            ['file' => 'Tenant-Logo/YEB.png', 'name' => 'YEB', 'as' => 'yeb.png'],
            ['file' => 'Tenant-Logo/ait.png', 'name' => 'AIT', 'as' => 'ait.png'],
            ['file' => 'Tenant-Logo/atum.png', 'name' => 'Atum', 'as' => 'atum.png'],
            ['file' => 'Tenant-Logo/big.png', 'name' => 'BIG', 'as' => 'big.png'],
            ['file' => 'Tenant-Logo/cdr.png', 'name' => 'CDR', 'as' => 'cdr.png'],
            ['file' => 'Tenant-Logo/pt nei.png', 'name' => 'PT NEI', 'as' => 'pt-nei.png'],
            ['file' => 'Tenant-Logo/singatac.png', 'name' => 'Singatac', 'as' => 'singatac.png'],
        ];

        foreach ($tenants as $t) {
            TenantLogo::create([
                'name' => $t['name'],
                'logo' => $this->img($t['file'], 'tenants', $t['as']),
            ]);
        }
    }

    /**
     * Copies an image from public/assets/img into storage/app/public/{folder}
     * and returns the path relative to the public disk (as stored by the app).
     */
    private function img(string $sourceRelative, string $folder, ?string $asFilename = null): string
    {
        $source = public_path('assets/img/' . $sourceRelative);
        $filename = $asFilename ?? basename($sourceRelative);
        $destRelative = $folder . '/' . $filename;
        $destFull = storage_path('app/public/' . $destRelative);

        if (!File::isDirectory(dirname($destFull))) {
            File::makeDirectory(dirname($destFull), 0755, true);
        }

        if (File::exists($source)) {
            File::copy($source, $destFull);
        }

        return $destRelative;
    }
}
