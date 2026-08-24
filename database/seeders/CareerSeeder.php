<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Career;
use Carbon\Carbon;

class CareerSeeder extends Seeder
{
    public function run()
    {
        Career::create([
            'title' => 'IT Support Staff',
            'slug' => Str::slug('IT Support Staff'),
            'location' => 'Bintan, Kepulauan Riau',
            'level' => 'Staff',
            'min_education' => 'D3/S1 Teknik Informatika/Sistem Informasi',
            'min_experience' => '1-2 Tahun',
            'description' => 'Bertanggung jawab dalam pemeliharaan infrastruktur IT, jaringan, dan perangkat komputer di lingkungan Bintan Industrial Estate, serta memberikan dukungan teknis kepada seluruh divisi.',
            'requirements' => "- Pendidikan minimal D3/S1 Teknik Informatika/Sistem Informasi\n- Pengalaman minimal 1-2 tahun di bidang IT support/helpdesk\n- Memahami dasar jaringan komputer dan troubleshooting hardware/software\n- Mampu bekerja secara mandiri maupun tim\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
            'status' => 'open',
            'posted_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
            'post_to_linkedin' => false,
        ]);

        Career::create([
            'title' => 'Warehouse Supervisor',
            'slug' => Str::slug('Warehouse Supervisor'),
            'location' => 'Bintan, Kepulauan Riau',
            'level' => 'Supervisor',
            'min_education' => 'D3/S1 Teknik Industri/Manajemen Logistik',
            'min_experience' => '3-5 Tahun',
            'description' => 'Mengawasi operasional pergudangan, mengelola stok barang, dan memastikan proses inbound-outbound berjalan efisien serta sesuai standar keselamatan kerja.',
            'requirements' => "- Pendidikan minimal D3/S1 Teknik Industri/Manajemen Logistik\n- Pengalaman minimal 3-5 tahun sebagai supervisor gudang/logistik\n- Memahami sistem manajemen inventori (WMS)\n- Memiliki jiwa kepemimpinan dan mampu mengelola tim\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
            'status' => 'open',
            'posted_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
            'post_to_linkedin' => false,
        ]);

        Career::create([
            'title' => 'Marketing Communication Officer',
            'slug' => Str::slug('Marketing Communication Officer'),
            'location' => 'Bintan, Kepulauan Riau',
            'level' => 'Staff/Officer',
            'min_education' => 'S1 Komunikasi/Marketing/Bisnis',
            'min_experience' => '2-3 Tahun',
            'description' => 'Mengelola strategi komunikasi pemasaran, materi promosi, dan konten digital untuk mendukung branding serta program pemasaran Bintan Industrial Estate.',
            'requirements' => "- Pendidikan minimal S1 Komunikasi/Marketing/Bisnis\n- Pengalaman minimal 2-3 tahun di bidang marketing communication\n- Memiliki kemampuan menulis dan komunikasi yang baik\n- Familiar dengan digital marketing dan media sosial\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
            'status' => 'open',
            'posted_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
            'post_to_linkedin' => false,
        ]);

        Career::create([
            'title' => 'Finance & Accounting Staff',
            'slug' => Str::slug('Finance & Accounting Staff'),
            'location' => 'Bintan, Kepulauan Riau',
            'level' => 'Staff',
            'min_education' => 'S1 Akuntansi/Keuangan',
            'min_experience' => '1-3 Tahun',
            'description' => 'Menangani pencatatan transaksi keuangan, penyusunan laporan keuangan, serta mendukung proses administrasi finance dan accounting perusahaan.',
            'requirements' => "- Pendidikan minimal S1 Akuntansi/Keuangan\n- Pengalaman minimal 1-3 tahun di bidang finance/accounting\n- Memahami prinsip akuntansi dasar dan perpajakan\n- Teliti, jujur, dan mampu bekerja dengan target/deadline\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
            'status' => 'open',
            'posted_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
            'post_to_linkedin' => false,
        ]);

        Career::create([
            'title' => 'Environmental Health & Safety (EHS) Officer',
            'slug' => Str::slug('Environmental Health & Safety EHS Officer'),
            'location' => 'Bintan, Kepulauan Riau',
            'level' => 'Staff/Officer',
            'min_education' => 'S1 Teknik Lingkungan/K3',
            'min_experience' => '2-4 Tahun',
            'description' => 'Mengawasi implementasi standar kesehatan, keselamatan kerja, dan pengelolaan lingkungan di area Bintan Industrial Estate sesuai regulasi yang berlaku.',
            'requirements' => "- Pendidikan minimal S1 Teknik Lingkungan/K3\n- Pengalaman minimal 2-4 tahun di bidang EHS/K3\n- Memiliki sertifikasi Ahli K3 Umum diutamakan\n- Memahami regulasi lingkungan dan keselamatan kerja\n- Berdomisili di Bintan atau bersedia ditempatkan di Bintan",
            'status' => 'open',
            'posted_date' => Carbon::now(),
            'closing_date' => Carbon::now()->addDays(30),
            'post_to_linkedin' => false,
        ]);
    }
}
