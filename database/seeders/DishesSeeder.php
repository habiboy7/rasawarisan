<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Dish;

class DishesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Aceh' => ['Mie Aceh', 'Kuah Pliek U'],
            'Sumatera Utara' => ['Bika Ambon', 'Soto Medan'],
            'Sumatera Barat' => ['Rendang', 'Dendeng Balado'],
            'Riau' => ['Gulai Ikan Patin', 'Asam Pedas'],
            'Kepulauan Riau' => ['Laksa Johor', 'Luti Gendang'],
            'Jambi' => ['Gulai Tempoyak', 'Nasi Gemuk'],
            'Bengkulu' => ['Pendap', 'Lema'],
            'Sumatera Selatan' => ['Pempek', 'Tekwan'],
            'Lampung' => ['Seruit', 'Gulai Taboh'],
            'Bangka Belitung' => ['Lempah Kuning', 'Mie Bangka'],

            'DKI Jakarta' => ['Kerak Telor', 'Soto Betawi'],
            'Jawa Barat' => ['Nasi Timbel', 'Seblak'],
            'Jawa Tengah' => ['Lumpia Semarang', 'Garang Asem'],
            'DI Yogyakarta' => ['Gudeg', 'Bakpia'],
            'Jawa Timur' => ['Rawon', 'Rujak Cingur'],
            'Banten' => ['Sate Bandeng', 'Rabeg'],

            'Kalimantan Barat' => ['Pengkang', 'Bubur Pedas'],
            'Kalimantan Tengah' => ['Juhu Singkah', 'Ketupat Kandangan'],
            'Kalimantan Selatan' => ['Soto Banjar', 'Ketupat Kandangan'],
            'Kalimantan Timur' => ['Gence Ruan', 'Sambal Raja'],
            'Kalimantan Utara' => ['Sate Ikan Pari', 'Gaguduh'],

            'Sulawesi Utara' => ['Cakalang Fufu', 'Tinutuan'],
            'Sulawesi Tengah' => ['Kaledo', 'Uta Dada'],
            'Sulawesi Selatan' => ['Coto Makassar', 'Pallubasa'],
            'Sulawesi Tenggara' => ['Sinonggi', 'Lapa-Lapa'],
            'Gorontalo' => ['Binte Biluhuta', 'Ilabulo'],
            'Sulawesi Barat' => ['Jepa', 'Ubi Tumbuk'],

            'Bali' => ['Ayam Betutu', 'Sate Lilit'],
            'Nusa Tenggara Barat' => ['Ayam Taliwang', 'Sate Rembiga'],
            'Nusa Tenggara Timur' => ['Sei Sapi', 'Kolo'],

            'Maluku' => ['Ikan Bakar Colo-colo', 'Papeda'],
            'Maluku Utara' => ['Gohu Ikan', 'Halua Kenari'],

            'Papua' => ['Papeda', 'Ikan Kuah Kuning'],
            'Papua Barat' => ['Udang Selingkuh', 'Ikan Bungkus'],
            'Papua Tengah' => ['Sagu Bakar', 'Sinole'],
            'Papua Pegunungan' => ['Bakar Batu', 'Udang Selingkuh'],
            'Papua Selatan' => ['Kapurut', 'Ikan Bakar Merauke'],
        ];

        foreach ($data as $provinsi => $dishes) {
            $region = Region::where('name', $provinsi)->first();

            if (!$region) continue;

            foreach ($dishes as $dishName) {
                Dish::create([
                    'region_id' => $region->id,
                    'name' => $dishName,
                    'short_description' => "Makanan khas dari $provinsi.",
                    'history' => "$dishName adalah makanan tradisional yang berasal dari $provinsi.",
                    'recipe' => "Resep lengkap akan ditambahkan.",
                    'main_image_url' => "https://source.unsplash.com/600x400/?" . str_replace(' ', '-', $dishName),
                    'likes_count' => rand(10, 500),
                    'popularity_score' => rand(1, 100)
                ]);
            }
        }
    }
}
