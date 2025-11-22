<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Partner;
use App\Models\Region;
use App\Models\Dish;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data yang dibutuhkan
        $user = User::first();
        $partners = Partner::where('is_verified', true)->take(10)->get();
        $regions = Region::where('type', 'provinsi')->take(15)->get();
        $dishes = Dish::inRandomOrder()->take(20)->get();

        $categories = ['lomba', 'festival', 'workshop', 'bazaar', 'pameran', 'lainnya'];
        $statuses = ['approved', 'approved', 'approved', 'pending', 'draft']; // Lebih banyak approved

        $eventTemplates = [
            [
                'title' => 'Festival Kuliner Nusantara 2025',
                'category' => 'festival',
                'description' => 'Festival kuliner terbesar se-Indonesia yang menampilkan berbagai makanan khas dari Sabang sampai Merauke. Nikmati berbagai hidangan tradisional, kompetisi memasak, dan pertunjukan budaya.',
            ],
            [
                'title' => 'Lomba Masak Rendang Tingkat Nasional',
                'category' => 'lomba',
                'description' => 'Kompetisi memasak rendang dengan hadiah total 50 juta rupiah. Terbuka untuk umum dengan kategori profesional dan amatir.',
            ],
            [
                'title' => 'Workshop Membuat Batik Kuliner',
                'category' => 'workshop',
                'description' => 'Belajar membuat kue dan makanan dengan motif batik bersama chef ternama. Dapatkan sertifikat setelah mengikuti workshop.',
            ],
            [
                'title' => 'Bazaar Makanan Tradisional Yogyakarta',
                'category' => 'bazaar',
                'description' => 'Bazaar makanan khas Yogyakarta dengan lebih dari 100 tenant UMKM lokal. Gratis untuk umum!',
            ],
            [
                'title' => 'Pameran Sejarah Kuliner Indonesia',
                'category' => 'pameran',
                'description' => 'Pameran interaktif tentang sejarah dan evolusi kuliner Indonesia dari masa ke masa. Cocok untuk keluarga dan pelajar.',
            ],
            [
                'title' => 'Festival Gudeg Jogja',
                'category' => 'festival',
                'description' => 'Rayakan keragaman gudeg Jogja! Cicipi berbagai varian gudeg dari berbagai penjual legendaris di Yogyakarta.',
            ],
            [
                'title' => 'Kompetisi Memasak Pempek Palembang',
                'category' => 'lomba',
                'description' => 'Lomba membuat pempek dengan bahan rahasia. Terbuka untuk umum, pendaftaran terbatas 50 peserta.',
            ],
            [
                'title' => 'Workshop Fusion Food: Tradisional Meets Modern',
                'category' => 'workshop',
                'description' => 'Pelajari cara mengkreasikan makanan tradisional dengan sentuhan modern yang Instagram-able namun tetap mempertahankan cita rasa asli.',
            ],
            [
                'title' => 'Pekan Raya Makanan Khas Sumatera',
                'category' => 'festival',
                'description' => 'Festival makanan khas Sumatera selama seminggu penuh. Live cooking demo, musik tradisional, dan games berhadiah!',
            ],
            [
                'title' => 'Kuliner Night Market Jakarta',
                'category' => 'bazaar',
                'description' => 'Night market dengan konsep street food dari berbagai daerah. Buka setiap Jumat-Minggu malam dengan live music.',
            ],
        ];

        foreach ($eventTemplates as $index => $template) {
            $region = $regions->random();
            $partner = $partners->random();
            $dish = $dishes->random();
            $status = $statuses[array_rand($statuses)];

            // Random date: antara sekarang sampai 6 bulan ke depan
            $startDate = Carbon::now()->addDays(rand(-30, 180));
            $endDate = (clone $startDate)->addDays(rand(1, 7));

            $event = Event::create([
                'user_id' => $user->id,
                'partner_id' => $partner->id,
                'region_id' => $region->id,
                'dish_id' => rand(0, 1) ? $dish->id : null, // 50% chance ada dish

                'title' => $template['title'],
                'category' => $template['category'],
                'description' => $template['description'],

                'poster_url' => "https://source.unsplash.com/800x600/?food,festival," . urlencode($template['title']),

                'location_name' => "Gedung Serbaguna " . $region->name,
                'location_address' => "Jl. Sudirman No. " . rand(1, 100) . ", " . $region->name,
                'location_lat' => $region->center_lat + (rand(-50, 50) / 1000),
                'location_lng' => $region->center_lng + (rand(-50, 50) / 1000),

                'start_date' => $startDate,
                'end_date' => $endDate,

                'ticket_price' => rand(0, 1) ? 0 : rand(25000, 150000),
                'max_participants' => rand(0, 1) ? null : rand(50, 500),
                'registration_url' => rand(0, 1) ? 'https://forms.gle/example' . $index : null,

                'organizer_name' => $partner->name,
                'organizer_email' => $partner->email ?? "event{$index}@example.com",
                'organizer_phone' => $partner->phone ?? '08' . rand(1000000000, 9999999999),

                'status' => $status,
                'is_featured' => rand(0, 4) == 0, // 20% chance featured
                'view_count' => rand(0, 500),

                'approved_by' => $status === 'approved' ? $user->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 30)) : null,
            ]);
        }

        // Tambah beberapa event tambahan random
        for ($i = 0; $i < 15; $i++) {
            $region = $regions->random();
            $partner = $partners->random();
            $category = $categories[array_rand($categories)];
            $status = $statuses[array_rand($statuses)];

            $startDate = Carbon::now()->addDays(rand(-30, 180));
            $endDate = (clone $startDate)->addDays(rand(1, 5));

            Event::create([
                'user_id' => $user->id,
                'partner_id' => $partner->id,
                'region_id' => $region->id,
                'dish_id' => rand(0, 1) ? $dishes->random()->id : null,

                'title' => ucfirst($category) . " Kuliner " . $region->name . " " . Carbon::now()->year,
                'category' => $category,
                'description' => "Event kuliner menarik di {$region->name}. Jangan lewatkan kesempatan untuk merasakan berbagai makanan khas dan bertemu dengan para pelaku UMKM lokal.",

                'poster_url' => "https://source.unsplash.com/800x600/?culinary,event,{$category}",

                'location_name' => "Venue Event " . $region->name,
                'location_address' => "Jl. Raya " . $region->name . " No. " . rand(1, 200),
                'location_lat' => $region->center_lat + (rand(-50, 50) / 1000),
                'location_lng' => $region->center_lng + (rand(-50, 50) / 1000),

                'start_date' => $startDate,
                'end_date' => $endDate,

                'ticket_price' => rand(0, 1) ? 0 : rand(20000, 100000),
                'max_participants' => rand(0, 1) ? null : rand(100, 300),
                'registration_url' => null,

                'organizer_name' => $partner->name,
                'organizer_email' => $partner->email ?? "organizer{$i}@example.com",
                'organizer_phone' => $partner->phone ?? '08' . rand(1000000000, 9999999999),

                'status' => $status,
                'is_featured' => rand(0, 9) == 0, // 10% chance
                'view_count' => rand(0, 1000),

                'approved_by' => $status === 'approved' ? $user->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 60)) : null,
            ]);
        }
    }
}
