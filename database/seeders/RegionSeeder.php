<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar pulau utama
        $pulauList = [
            'Sumatra',
            'Jawa',
            'Kalimantan',
            'Sulawesi',
            'Bali dan Nusa Tenggara',
            'Maluku',
            'Papua',
        ];

        $pulauIds = [];

        // Masukkan data pulau
        foreach ($pulauList as $pulau) {
            $pulauModel = Region::create([
                'name' => $pulau,
                'type' => 'pulau',
                'parent_id' => null,
            ]);
            $pulauIds[$pulau] = $pulauModel->id;
        }

        // Daftar provinsi sesuai pulau
        $provinsiData = [
            'Sumatra' => [
                'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau',
                'Kepulauan Riau', 'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Lampung', 'Bangka Belitung'
            ],
            'Jawa' => [
                'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten'
            ],
            'Kalimantan' => [
                'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara'
            ],
            'Sulawesi' => [
                'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat'
            ],
            'Bali dan Nusa Tenggara' => [
                'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur'
            ],
            'Maluku' => [
                'Maluku', 'Maluku Utara'
            ],
            'Papua' => [
                'Papua', 'Papua Barat', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan'
            ],
        ];

        // Masukkan data provinsi
        foreach ($provinsiData as $pulau => $provinsiList) {
            foreach ($provinsiList as $provinsi) {
                Region::create([
                    'name' => $provinsi,
                    'type' => 'provinsi',
                    'parent_id' => $pulauIds[$pulau] ?? null,
                ]);
            }
        }
    }
}
