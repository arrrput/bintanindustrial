<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::create([
            'title' => 'Program CSR Bintan Industrial Estate untuk Masyarakat Sekitar',
            'slug' => Str::slug('Program CSR Bintan Industrial Estate untuk Masyarakat Sekitar'),
            'image' => json_encode(['blogs/CSRProgram2026.jpg']),
            'excerpt' => 'Bintan Industrial Estate menjalankan program tanggung jawab sosial perusahaan berupa bantuan pendidikan dan pemberdayaan masyarakat di sekitar kawasan industri.',
            'content' => "Sebagai wujud kepedulian terhadap masyarakat sekitar, Bintan Industrial Estate menggelar rangkaian program Corporate Social Responsibility (CSR) yang mencakup bantuan pendidikan, pelatihan keterampilan, dan pemberdayaan ekonomi warga di sekitar kawasan industri.\n\nProgram ini melibatkan kerja sama dengan pemerintah desa setempat serta tenant-tenant yang beroperasi di dalam kawasan, guna memastikan manfaat pertumbuhan industri turut dirasakan oleh masyarakat sekitar.",
            'post_to_ig' => false,
        ]);

        Blog::create([
            'title' => 'Bintan Industrial Estate Gelar Job Fair untuk Warga Lokal',
            'slug' => Str::slug('Bintan Industrial Estate Gelar Job Fair untuk Warga Lokal'),
            'image' => json_encode(['blogs/JobFair2026.jpg']),
            'excerpt' => 'Ratusan pencari kerja dari Bintan dan sekitarnya menghadiri job fair yang diselenggarakan Bintan Industrial Estate bersama para tenant.',
            'content' => "Bintan Industrial Estate bersama sejumlah tenant menyelenggarakan job fair guna membuka lebih banyak kesempatan kerja bagi masyarakat lokal. Acara ini diikuti oleh ratusan pencari kerja dari Bintan dan pulau-pulau sekitarnya.\n\nMelalui kegiatan ini, perusahaan-perusahaan yang berlokasi di kawasan industri dapat menjaring talenta lokal secara langsung, sekaligus mendukung penyerapan tenaga kerja daerah.",
            'post_to_ig' => false,
        ]);

        Blog::create([
            'title' => 'Penambahan Tenant Baru Perkuat Ekosistem Industri Bintan',
            'slug' => Str::slug('Penambahan Tenant Baru Perkuat Ekosistem Industri Bintan'),
            'image' => json_encode(['blogs/NewTenant2026.webp']),
            'excerpt' => 'Sejumlah perusahaan manufaktur internasional resmi bergabung sebagai tenant baru di Bintan Industrial Estate.',
            'content' => "Bintan Industrial Estate kembali menyambut kedatangan tenant baru dari berbagai sektor manufaktur. Kehadiran tenant-tenant ini memperkuat ekosistem industri di kawasan serta membuka lapangan kerja baru bagi masyarakat sekitar.\n\nKeputusan para investor untuk berinvestasi di Bintan tidak terlepas dari keunggulan lokasi yang strategis, kemudahan perizinan, serta infrastruktur kawasan yang terus dikembangkan.",
            'post_to_ig' => false,
        ]);

        Blog::create([
            'title' => 'Bintan Industrial Estate Raih Penghargaan Kawasan Industri Terbaik',
            'slug' => Str::slug('Bintan Industrial Estate Raih Penghargaan Kawasan Industri Terbaik'),
            'image' => json_encode(['blogs/AwardRecognition2026.jpg']),
            'excerpt' => 'Komitmen terhadap kualitas layanan dan infrastruktur membawa Bintan Industrial Estate meraih penghargaan sebagai kawasan industri terbaik.',
            'content' => "Bintan Industrial Estate menerima penghargaan atas kontribusinya dalam pengembangan kawasan industri yang berkelanjutan dan ramah investor. Penghargaan ini diberikan atas dasar penilaian terhadap kualitas infrastruktur, pelayanan tenant, dan dampak ekonomi bagi daerah.\n\nPencapaian ini menjadi motivasi bagi seluruh tim untuk terus meningkatkan standar layanan dan fasilitas bagi para tenant yang berinvestasi di Bintan Industrial Estate.",
            'post_to_ig' => false,
        ]);

        Blog::create([
            'title' => 'Peningkatan Infrastruktur Jalan dan Utilitas di Kawasan Industri',
            'slug' => Str::slug('Peningkatan Infrastruktur Jalan dan Utilitas di Kawasan Industri'),
            'image' => json_encode(['blogs/InfrastructureUpgrade2026.jpg']),
            'excerpt' => 'Bintan Industrial Estate melakukan peningkatan infrastruktur jalan, drainase, dan utilitas untuk mendukung kelancaran operasional tenant.',
            'content' => "Guna mendukung kelancaran operasional para tenant, Bintan Industrial Estate melaksanakan proyek peningkatan infrastruktur meliputi perbaikan jalan, sistem drainase, serta jaringan utilitas di dalam kawasan.\n\nPeningkatan infrastruktur ini merupakan bagian dari komitmen jangka panjang perusahaan untuk memastikan kawasan tetap kompetitif dan nyaman bagi seluruh tenant serta pekerja yang beraktivitas di dalamnya.",
            'post_to_ig' => false,
        ]);
    }
}
