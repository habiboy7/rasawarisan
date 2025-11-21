<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Dish;

class DishesSeeder extends Seeder
{
    public function run(): void
    {
        // Data makanan dengan kabupaten
        $data = [
            'Aceh' => [
                ['name' => 'Mie Aceh', 'kabupaten' => 'Kota Banda Aceh'],
                ['name' => 'Kuah Pliek U', 'kabupaten' => 'Aceh Besar'],
            ],
            'Sumatera Utara' => [
                ['name' => 'Bika Ambon', 'kabupaten' => 'Kota Medan'],
                ['name' => 'Soto Medan', 'kabupaten' => 'Kota Medan'],
            ],
            'Sumatera Barat' => [
                ['name' => 'Rendang', 'kabupaten' => 'Kota Padang'],
                ['name' => 'Dendeng Balado', 'kabupaten' => 'Kota Bukittinggi'],
            ],
            'Riau' => [
                ['name' => 'Gulai Ikan Patin', 'kabupaten' => 'Kota Pekanbaru'],
                ['name' => 'Asam Pedas', 'kabupaten' => 'Bengkalis'],
            ],
            'Kepulauan Riau' => [
                ['name' => 'Laksa Johor', 'kabupaten' => 'Kota Batam'],
                ['name' => 'Luti Gendang', 'kabupaten' => 'Kota Tanjungpinang'],
            ],
            'Jambi' => [
                ['name' => 'Gulai Tempoyak', 'kabupaten' => 'Kota Jambi'],
                ['name' => 'Nasi Gemuk', 'kabupaten' => 'Merangin'],
            ],
            'Bengkulu' => [
                ['name' => 'Pendap', 'kabupaten' => 'Kota Bengkulu'],
                ['name' => 'Lema', 'kabupaten' => 'Bengkulu Utara'],
            ],
            'Sumatera Selatan' => [
                ['name' => 'Pempek', 'kabupaten' => 'Kota Palembang'],
                ['name' => 'Tekwan', 'kabupaten' => 'Kota Palembang'],
            ],
            'Lampung' => [
                ['name' => 'Seruit', 'kabupaten' => 'Kota Bandar Lampung'],
                ['name' => 'Gulai Taboh', 'kabupaten' => 'Lampung Barat'],
            ],
            'Bangka Belitung' => [
                ['name' => 'Lempah Kuning', 'kabupaten' => 'Kota Pangkalpinang'],
                ['name' => 'Mie Bangka', 'kabupaten' => 'Bangka'],
            ],

            'DKI Jakarta' => [
                ['name' => 'Kerak Telor', 'kabupaten' => 'Jakarta Pusat'],
                ['name' => 'Soto Betawi', 'kabupaten' => 'Jakarta Selatan'],
            ],
            'Jawa Barat' => [
                ['name' => 'Nasi Timbel', 'kabupaten' => 'Kota Bandung'],
                ['name' => 'Seblak', 'kabupaten' => 'Kota Bandung'],
            ],
            'Jawa Tengah' => [
                ['name' => 'Lumpia Semarang', 'kabupaten' => 'Kota Semarang'],
                ['name' => 'Garang Asem', 'kabupaten' => 'Kota Semarang'],
            ],
            'DI Yogyakarta' => [
                ['name' => 'Gudeg', 'kabupaten' => 'Kota Yogyakarta'],
                ['name' => 'Bakpia', 'kabupaten' => 'Kota Yogyakarta'],
            ],
            'Jawa Timur' => [
                ['name' => 'Rawon', 'kabupaten' => 'Kota Surabaya'],
                ['name' => 'Rujak Cingur', 'kabupaten' => 'Kota Surabaya'],
            ],
            'Banten' => [
                ['name' => 'Sate Bandeng', 'kabupaten' => 'Kota Serang'],
                ['name' => 'Rabeg', 'kabupaten' => 'Kota Serang'],
            ],

            'Kalimantan Barat' => [
                ['name' => 'Pengkang', 'kabupaten' => 'Kota Pontianak'],
                ['name' => 'Bubur Pedas', 'kabupaten' => 'Sambas'],
            ],
            'Kalimantan Tengah' => [
                ['name' => 'Juhu Singkah', 'kabupaten' => 'Kota Palangka Raya'],
                ['name' => 'Ketupat Kandangan', 'kabupaten' => 'Kapuas'],
            ],
            'Kalimantan Selatan' => [
                ['name' => 'Soto Banjar', 'kabupaten' => 'Kota Banjarmasin'],
                ['name' => 'Ketupat Kandangan', 'kabupaten' => 'Hulu Sungai Selatan'],
            ],
            'Kalimantan Timur' => [
                ['name' => 'Gence Ruan', 'kabupaten' => 'Kota Samarinda'],
                ['name' => 'Sambal Raja', 'kabupaten' => 'Kutai Kartanegara'],
            ],
            'Kalimantan Utara' => [
                ['name' => 'Sate Ikan Pari', 'kabupaten' => 'Kota Tarakan'],
                ['name' => 'Gaguduh', 'kabupaten' => 'Bulungan'],
            ],

            'Sulawesi Utara' => [
                ['name' => 'Cakalang Fufu', 'kabupaten' => 'Kota Manado'],
                ['name' => 'Tinutuan', 'kabupaten' => 'Kota Manado'],
            ],
            'Sulawesi Tengah' => [
                ['name' => 'Kaledo', 'kabupaten' => 'Kota Palu'],
                ['name' => 'Uta Dada', 'kabupaten' => 'Donggala'],
            ],
            'Sulawesi Selatan' => [
                ['name' => 'Coto Makassar', 'kabupaten' => 'Kota Makassar'],
                ['name' => 'Pallubasa', 'kabupaten' => 'Kota Makassar'],
            ],
            'Sulawesi Tenggara' => [
                ['name' => 'Sinonggi', 'kabupaten' => 'Kota Kendari'],
                ['name' => 'Lapa-Lapa', 'kabupaten' => 'Buton'],
            ],
            'Gorontalo' => [
                ['name' => 'Binte Biluhuta', 'kabupaten' => 'Kota Gorontalo'],
                ['name' => 'Ilabulo', 'kabupaten' => 'Gorontalo'],
            ],
            'Sulawesi Barat' => [
                ['name' => 'Jepa', 'kabupaten' => 'Mamuju'],
                ['name' => 'Ubi Tumbuk', 'kabupaten' => 'Majene'],
            ],

            'Bali' => [
                ['name' => 'Ayam Betutu', 'kabupaten' => 'Gianyar'],
                ['name' => 'Sate Lilit', 'kabupaten' => 'Badung'],
            ],
            'Nusa Tenggara Barat' => [
                ['name' => 'Ayam Taliwang', 'kabupaten' => 'Kota Mataram'],
                ['name' => 'Sate Rembiga', 'kabupaten' => 'Lombok Timur'],
            ],
            'Nusa Tenggara Timur' => [
                ['name' => 'Sei Sapi', 'kabupaten' => 'Kota Kupang'],
                ['name' => 'Kolo', 'kabupaten' => 'Manggarai'],
            ],

            'Maluku' => [
                ['name' => 'Ikan Bakar Colo-colo', 'kabupaten' => 'Kota Ambon'],
                ['name' => 'Papeda', 'kabupaten' => 'Maluku Tengah'],
            ],
            'Maluku Utara' => [
                ['name' => 'Gohu Ikan', 'kabupaten' => 'Kota Ternate'],
                ['name' => 'Halua Kenari', 'kabupaten' => 'Halmahera Utara'],
            ],

            'Papua' => [
                ['name' => 'Papeda', 'kabupaten' => 'Kota Jayapura'],
                ['name' => 'Ikan Kuah Kuning', 'kabupaten' => 'Jayapura'],
            ],
            'Papua Barat' => [
                ['name' => 'Udang Selingkuh', 'kabupaten' => 'Kota Sorong'],
                ['name' => 'Ikan Bungkus', 'kabupaten' => 'Raja Ampat'],
            ],
            'Papua Tengah' => [
                ['name' => 'Sagu Bakar', 'kabupaten' => 'Mimika'],
                ['name' => 'Sinole', 'kabupaten' => 'Nabire'],
            ],
            'Papua Pegunungan' => [
                ['name' => 'Bakar Batu', 'kabupaten' => 'Jayawijaya'],
                ['name' => 'Udang Selingkuh', 'kabupaten' => 'Lanny Jaya'],
            ],
            'Papua Selatan' => [
                ['name' => 'Kapurut', 'kabupaten' => 'Merauke'],
                ['name' => 'Ikan Bakar Merauke', 'kabupaten' => 'Merauke'],
            ],
        ];

        foreach ($data as $provinsi => $dishes) {
            $region = Region::where('name', $provinsi)
                ->where('type', 'provinsi')
                ->first();

            if (!$region) continue;

            foreach ($dishes as $dishData) {
                // Cari kabupaten
                $kabupaten = Region::where('name', $dishData['kabupaten'])
                    ->where('parent_id', $region->id)
                    ->where('type', 'kabupaten')
                    ->first();

                Dish::create([
                    'region_id' => $region->id,
                    'kabupaten_id' => $kabupaten ? $kabupaten->id : null,
                    'name' => $dishData['name'],
                    'short_description' => "Makanan khas dari {$dishData['kabupaten']}, $provinsi.",
                    'history' => "{$dishData['name']} adalah makanan tradisional yang berasal dari {$dishData['kabupaten']}, $provinsi.",
                    'recipe' => "Resep lengkap akan ditambahkan.",
                    'main_image_url' => "https://source.unsplash.com/600x400/?" . str_replace(' ', '-', $dishData['name']),
                    'likes_count' => rand(10, 500),
                    'popularity_score' => rand(1, 100)
                ]);
            }
        }
    }
}