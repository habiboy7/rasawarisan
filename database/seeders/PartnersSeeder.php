<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Partner;
use App\Models\PartnerProduct;
use App\Models\Dish;

class PartnersSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kabupaten (bukan provinsi)
        $kabupatenList = Region::where('type', 'kabupaten')
            ->with('parent') // eager load provinsi induk
            ->get();

        foreach ($kabupatenList as $kab) {
            // Skip jika tidak punya parent (provinsi)
            if (!$kab->parent) continue;

            $provinsi = $kab->parent;

            // Buat 1 partner per kabupaten
            $partner = Partner::create([
                'user_id' => 1, // dummy user
                'region_id' => $provinsi->id,
                'kabupaten_id' => $kab->id,
                'name' => "Kuliner Khas " . $kab->name,
                'address' => "Jl. Raya " . $kab->name . " No. " . rand(1, 100),
                'lat' => $kab->center_lat ?? ($provinsi->center_lat + (rand(-50, 50) / 1000)),
                'lng' => $kab->center_lng ?? ($provinsi->center_lng + (rand(-50, 50) / 1000)),
                'phone' => '08' . rand(1000000000, 9999999999),
                'email' => strtolower(str_replace([' ', '.'], '', $kab->name)) . "@kuliner.com",
                'logo_url' => "https://source.unsplash.com/400x300/?restaurant," . urlencode($kab->name),
                'description' => "Warung makan yang menyajikan kuliner khas dari " . $kab->name . ", " . $provinsi->name . ". Kami menyediakan makanan tradisional dengan cita rasa autentik dan harga terjangkau.",
                'is_verified' => rand(0, 1) ? true : false, // Random verified
            ]);

            // Ambil makanan yang ada di kabupaten ini (max 2)
            $dishes = Dish::where('kabupaten_id', $kab->id)->take(2)->get();

            // Jika tidak ada makanan di kabupaten ini, ambil dari provinsi
            if ($dishes->isEmpty()) {
                $dishes = Dish::where('region_id', $provinsi->id)
                    ->whereNull('kabupaten_id')
                    ->take(2)
                    ->get();
            }

            // Jika masih kosong, skip
            if ($dishes->isEmpty()) continue;

            // Buat product untuk setiap makanan
            foreach ($dishes as $dish) {
                PartnerProduct::create([
                    'partner_id' => $partner->id,
                    'dish_id' => $dish->id,
                    'name' => $dish->name,
                    'price' => rand(15000, 75000),
                    'image_url' => $dish->main_image_url,
                    'description' => "Menu spesial " . $dish->name . " dengan resep turun temurun.",
                    'available' => rand(0, 10) > 1, // 90% available
                ]);
            }
        }

        // Optional: Tambah beberapa partner tambahan di kota-kota besar
        $kotaBesar = [
            'Kota Medan',
            'Kota Bandung',
            'Kota Surabaya',
            'Kota Semarang',
            'Kota Yogyakarta',
            'Kota Makassar',
            'Kota Palembang',
            'Jakarta Pusat'
        ];

        foreach ($kotaBesar as $namaKota) {
            $kota = Region::where('name', $namaKota)
                ->where('type', 'kabupaten')
                ->with('parent')
                ->first();

            if (!$kota || !$kota->parent) continue;

            // Buat 2-3 partner tambahan di kota besar
            for ($i = 1; $i <= rand(2, 3); $i++) {
                $partner = Partner::create([
                    'user_id' => 1,
                    'region_id' => $kota->parent->id,
                    'kabupaten_id' => $kota->id,
                    'name' => "Restoran " . $namaKota . " #" . $i,
                    'address' => "Jl. Utama " . $namaKota . " No. " . rand(50, 200),
                    'lat' => $kota->center_lat + (rand(-20, 20) / 1000),
                    'lng' => $kota->center_lng + (rand(-20, 20) / 1000),
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'email' => strtolower(str_replace(' ', '', $namaKota)) . $i . "@resto.com",
                    'logo_url' => "https://source.unsplash.com/400x300/?restaurant,food",
                    'description' => "Restoran modern yang menyajikan makanan khas " . $kota->parent->name . " dengan suasana nyaman.",
                    'is_verified' => true,
                ]);

                // Ambil 3-4 dishes random dari kabupaten atau provinsi ini
                $dishes = Dish::where('kabupaten_id', $kota->id)
                    ->orWhere('region_id', $kota->parent->id)
                    ->inRandomOrder()
                    ->take(rand(3, 4))
                    ->get();

                foreach ($dishes as $dish) {
                    PartnerProduct::create([
                        'partner_id' => $partner->id,
                        'dish_id' => $dish->id,
                        'name' => $dish->name,
                        'price' => rand(20000, 100000),
                        'image_url' => $dish->main_image_url,
                        'description' => "Hidangan spesial " . $dish->name,
                        'available' => true,
                    ]);
                }
            }
        }
    }
}
