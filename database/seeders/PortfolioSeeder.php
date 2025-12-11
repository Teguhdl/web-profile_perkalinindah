<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Portfolio::truncate();

        $data = [
            [
                'title' => 'Pengadaan Rubber Fender Dermaga A',
                'image' => 'assets/web/products/w-fender.jpg', // Placeholder image
                'client' => 'PT. Pelabuhan Indonesia (PELINDO)',
                'year' => 2023,
                'status' => 'Completed',
                'description' => 'Supply dan instalasi rubber fender tipe V untuk dermaga kargo.',
            ],
            [
                'title' => 'Supply Expansion Joint Jembatan Suramadu',
                'image' => 'assets/web/products/expansion-joint.png', // Placeholder image
                'client' => 'PT. Waskita Karya',
                'year' => 2024,
                'status' => 'On Progress',
                'description' => 'Penyediaan expansion joint strip seal untuk pemeliharaan jembatan.',
            ],
            [
                'title' => 'Pembuatan Roller Conveyor Tambang',
                'image' => 'assets/web/products/roller-pu.jpg', // Placeholder
                'client' => 'PT. Adaro Energy',
                'year' => 2022,
                'status' => 'Completed',
                'description' => 'Produksi heavy duty roller conveyor untuk sistem transportasi batubara.',
            ],
            [
                'title' => 'Rubber Bearing Pad Tol Trans Jawa',
                'client' => 'PT. Jasa Marga',
                'year' => 2023,
                'status' => 'Completed',
                'description' => 'Suplai bantalan karet jembatan untuk proyek jalan tol.',
            ],
            [
                'title' => 'Perbaikan Fender Tugboat',
                'client' => 'PT. Pertamina Trans Kontinental',
                'year' => 2024,
                'status' => 'Completed',
                'description' => 'Rekondisi dan pemasangan baru W Fender untuk armada tugboat.',
            ],
            [
                'title' => 'Project Cylinder Fender Jetty Batubara',
                'client' => 'PLN Batu Bara',
                'year' => 2021,
                'status' => 'Completed',
                'description' => 'Instalasi fender silinder pada jetty pembongkaran batubara.',
            ],
            [
                'title' => 'Supply Karet Bantalan Rel Kereta',
                'client' => 'PT. KAI',
                'year' => 2022,
                'status' => 'Completed',
                'description' => 'Pengadaan rubber pad untuk bantalan beton rel kereta api.',
            ],
            [
                'title' => 'Custom Seal Pintu Air Bendungan',
                'client' => 'Kementerian PUPR',
                'year' => 2023,
                'status' => 'Completed',
                'description' => 'Pembuatan seal karet custom ukuran besar untuk pintu air bendungan.',
            ],
            [
                'title' => 'Polyurethane Roller Pabrik Kertas',
                'client' => 'PT. Indah Kiat Pulp & Paper',
                'year' => 2024,
                'status' => 'On Progress',
                'description' => 'Recoating dan supply roller PU untuk mesin kertas.',
            ],
            [
                'title' => 'Dredging Hose 12 Inch',
                'client' => 'PT. Timah Tbk',
                'year' => 2022,
                'status' => 'Completed',
                'description' => 'Supply selang karet hisap lumpur untuk kapal keruk.',
            ]
        ];

        foreach ($data as $item) {
            \App\Models\Portfolio::create($item);
        }
    }
}
