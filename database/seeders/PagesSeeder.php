<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'id' => 1,
                'label' => 'Beranda',
                'slug' => '/',
                'parent_id' => 0,
                'view_name' => 'pages.dashboard',
                'meta_title' => 'PT. Perkalin Indah – Solusi Rubber, Polyurethane & Metal Part',
                'meta_description' => 'PT Perkalin Indah menyediakan berbagai produk industri berbahan karet, polyurethane, metal, dan plastik dengan standar manufaktur terbaik sejak 1973.',
                'meta_keywords' => 'perkalin indah, industri karet, polyurethane, metal part, plastic component, manufaktur indonesia',
            ],
            [
                'id' => 2,
                'label' => 'Tentang',
                'slug' => null,
                'parent_id' => 0,
                'view_name' => "-",
                'meta_title' => 'Tentang Kami – PT Perkalin Indah',
                'meta_description' => 'Informasi mengenai sejarah, profil, dan perkembangan PT Perkalin Indah sebagai perusahaan manufaktur komponen industri.',
                'meta_keywords' => 'tentang perkalin indah, company profile, sejarah perusahaan, industri manufaktur',
            ],
            [
                'id' => 3,
                'label' => 'Profil Perusahaan',
                'slug' => 'profil-perusahaan',
                'parent_id' => 2,
                'view_name' => 'pages.company-profile',
                'meta_title' => 'Profil Perusahaan – PT Perkalin Indah',
                'meta_description' => 'Profil lengkap PT Perkalin Indah yang bergerak di bidang manufaktur rubber, polyurethane, metal, dan plastic part sejak 1973.',
                'meta_keywords' => 'profil perusahaan, tentang kami, company profile, perkalin indah, industri manufaktur',
            ],
            [
                'id' => 4,
                'label' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'parent_id' => 2,
                'view_name' => 'pages.visi-misi',
                'meta_title' => 'Visi & Misi – PT Perkalin Indah',
                'meta_description' => 'Visi dan misi PT Perkalin Indah dalam menyediakan solusi industri yang inovatif, berkualitas, dan berbasis pada integritas.',
                'meta_keywords' => 'visi perusahaan, misi perusahaan, tujuan perusahaan, perkalin indah',
            ],
            [
                'id' => 5,
                'label' => 'Tim Kami',
                'slug' => 'tim-kami',
                'parent_id' => 2,
                'view_name' => 'pages.tim-kami',
                'meta_title' => 'Tim Kami – Profesional & Tenaga Ahli PT Perkalin Indah',
                'meta_description' => 'Kenali tim profesional dan manajemen PT Perkalin Indah yang berpengalaman dalam industri manufaktur karet, polyurethane, metal, dan plastik.',
                'meta_keywords' => 'tim perkalin indah, tenaga ahli, manajemen perusahaan, company team, industri karet, polyurethane team',
            ],
            [
                'id' => 6,
                'label' => 'Produk',
                'slug' => 'produk',
                'parent_id' => 0,
                'view_name' => 'pages.produk',
                'meta_title' => 'Produk – Rubber, Polyurethane, Metal & Plastic Parts PT Perkalin Indah',
                'meta_description' => 'Daftar produk unggulan PT Perkalin Indah meliputi rubber, polyurethane, metal, dan plastic parts dengan kualitas manufaktur terbaik.',
                'meta_keywords' => 'produk perkalin indah, rubber part, polyurethane product, metal component, plastic component, solusi industri',
            ],
            [
                'id' => 7,
                'label' => 'Mitra',
                'slug' => 'mitra',
                'parent_id' => 0,
                'view_name' => 'pages.mitra',
                'meta_title' => 'Mitra – Perusahaan yang Bekerja Sama dengan PT Perkalin Indah',
                'meta_description' => 'Daftar mitra dan perusahaan yang mempercayakan kebutuhan komponen rubber, polyurethane, metal, dan plastik kepada PT Perkalin Indah.',
                'meta_keywords' => 'mitra perusahaan, partners, company partners, klien industri, mitra manufaktur',
            ],
            [
                'id' => 8,
                'label' => 'Portofolio',
                'slug' => 'portofolio',
                'parent_id' => 0,
                'view_name' => 'pages.portofolio',
                'meta_title' => 'Portofolio – Proyek Kerja PT Perkalin Indah',
                'meta_description' => 'Daftar portofolio pekerjaan dan proyek yang telah diselesaikan oleh PT Perkalin Indah.',
                'meta_keywords' => 'portofolio perkalin, proyek karet, polyurethane project, sparepart industri',
            ]
        ];

        foreach ($pages as $pageData) {
            DB::table('pages')->updateOrInsert(
                ['id' => $pageData['id']],
                array_merge($pageData, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
