<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar bersih (opsional, hati-hati jika production)
        \App\Models\Product::truncate();

        $products = [
            [
                'title' => 'W Fender',
                'slug' => 'w-fender',
                'content' => 'W Fender adalah bumper karet pelindung yang meredam benturan antara kapal dan dermaga. Desain dua kaki fleksibel dan lubang tengahnya memudahkan pemasangan, ideal untuk lambung kapal melengkung seperti tugboat.',
                'image' => 'assets/web/products/w-fender.jpg',
            ],
            [
                'title' => 'Tubular Fender',
                'slug' => 'tubular-fender',
                'content' => 'Tubular Fender berbentuk silinder, berfungsi menyerap benturan dan melindungi kapal serta dermaga, ideal untuk kapal tunda dan sejenisnya.',
                'image' => 'assets/web/products/tubular-fender.jpg',
            ],
            [
                'title' => 'Rubber Unloading Tekstile',
                'slug' => 'rubber-unloading-tekstile',
                'content' => 'Rubber unloading tekstil adalah komponen karet pada mesin produksi tekstil yang membantu memindahkan atau menahan kain tanpa merusak teksturnya.',
                'image' => 'assets/web/products/rubber-unloading.jpg',
            ],
            [
                'title' => 'Rubber Roller PU (Polyurethane Roller)',
                'slug' => 'rubber-roller-pu',
                'content' => 'Roller PU berlapis polyurethane merah dengan inti logam, digunakan pada mesin industri untuk menahan, menuntun, dan menggerakkan material tanpa merusak permukaannya.',
                'image' => 'assets/web/products/roller-pu.jpg',
            ],
            [
                'title' => 'Rubber Coupling',
                'slug' => 'rubber-coupling',
                'content' => 'Kopling elastis dengan elemen karet yang mentransmisikan torsi sekaligus meredam getaran dan kejut beban, ideal untuk motor, pompa, blower, kompresor, dan gearbox.',
                'image' => 'assets/web/products/coupling.png',
            ],
            [
                'title' => 'Expansion Joint',
                'slug' => 'expansion-joint',
                'content' => 'Komponen karet fleksibel untuk meredam getaran dan perpindahan.',
                'image' => 'assets/web/products/expansion-joint.png',
            ],
            // TAMBAHAN DATA SAMPAI 10
            [
                'title' => 'D Fender',
                'slug' => 'd-fender',
                'content' => 'Fender karet tipe D yang umum digunakan untuk dermaga dan kapal kecil, memberikan perlindungan yang handal dan ekonomis.',
                'image' => null, // Placeholder if no image
            ],
            [
                'title' => 'Cylindrical Fender',
                'slug' => 'cylindrical-fender',
                'content' => 'Fender silinder sederhana namun kuat, cocok untuk berbagai jenis kapal dan dermaga kargo.',
                'image' => null,
            ],
            [
                'title' => 'Cell Fender',
                'slug' => 'cell-fender',
                'content' => 'Fender dermaga berkinerja tinggi dengan defleksi rendah dan penyerapan energi tinggi.',
                'image' => null,
            ],
            [
                'title' => 'Cone Fender',
                'slug' => 'cone-fender',
                'content' => 'Fender tipe kerucut generasi terbaru untuk stabilitas optimal dan ketahanan geser yang unggul.',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
