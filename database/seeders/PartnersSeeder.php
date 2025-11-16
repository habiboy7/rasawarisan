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
        // Ambil semua provinsi
        $provinsi = Region::where('type', 'provinsi')->get();

        foreach ($provinsi as $prov) {

            // Buat UMKM
            $partner = Partner::create([
                'user_id' => 1, // dummy
                'region_id' => $prov->id,
                'name' => "Kuliner Khas " . $prov->name,
                'address' => "Pusat kota " . $prov->name,
                'lat' => -2 + rand(-100, 100) / 100,
                'lng' => 118 + rand(-100, 100) / 100,
                'phone' => '08' . rand(1000000000, 9999999999),
                'email' => strtolower(str_replace(' ', '', $prov->name)) . "@kuliner.com",
                'logo_url' => "https://source.unsplash.com/400x300/?restaurant",
                'description' => "UMKM kuliner khas dari " . $prov->name,
                'is_verified' => true,
            ]);

            // Ambil max 2 makanan khas provinsi
            $dishes = Dish::where('region_id', $prov->id)->take(2)->get();

            foreach ($dishes as $dish) {
                PartnerProduct::create([
                    'partner_id' => $partner->id,
                    'dish_id' => $dish->id,
                    'name' => $dish->name,
                    'price' => rand(15000, 55000),
                    'image_url' => $dish->main_image_url,
                    'description' => "Menu khas " . $dish->name,
                    'available' => true,
                ]);
            }
        }
    }
}
