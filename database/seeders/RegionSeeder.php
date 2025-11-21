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

        $provinsiIds = [];

        // Masukkan data provinsi
        foreach ($provinsiData as $pulau => $provinsiList) {
            foreach ($provinsiList as $provinsi) {
                $prov = Region::create([
                    'name' => $provinsi,
                    'type' => 'provinsi',
                    'parent_id' => $pulauIds[$pulau] ?? null,
                ]);
                $provinsiIds[$provinsi] = $prov->id;
            }
        }

        // DATA KABUPATEN/KOTA PER PROVINSI
        $kabupatenData = [
            // SUMATRA
            'Aceh' => [
                'Kota Banda Aceh', 'Kota Sabang', 'Kota Lhokseumawe', 'Kota Langsa', 'Kota Subulussalam',
                'Aceh Besar', 'Aceh Barat', 'Aceh Selatan', 'Aceh Timur', 'Aceh Utara', 'Aceh Tengah',
                'Aceh Tenggara', 'Aceh Jaya', 'Aceh Singkil', 'Bener Meriah', 'Pidie', 'Pidie Jaya',
                'Bireuen', 'Aceh Barat Daya', 'Gayo Lues', 'Nagan Raya', 'Simeulue'
            ],
            'Sumatera Utara' => [
                'Kota Medan', 'Kota Binjai', 'Kota Tebing Tinggi', 'Kota Pematangsiantar', 'Kota Tanjungbalai',
                'Kota Sibolga', 'Kota Padangsidimpuan', 'Kota Gunungsitoli',
                'Deli Serdang', 'Serdang Bedagai', 'Langkat', 'Karo', 'Dairi', 'Toba', 'Samosir',
                'Asahan', 'Labuhanbatu', 'Labuhanbatu Utara', 'Labuhanbatu Selatan', 'Tapanuli Selatan',
                'Tapanuli Tengah', 'Tapanuli Utara', 'Humbang Hasundutan', 'Pakpak Bharat', 
                'Nias', 'Nias Selatan', 'Nias Utara', 'Nias Barat', 'Mandailing Natal', 'Padang Lawas',
                'Padang Lawas Utara', 'Batu Bara', 'Simalungun'
            ],
            'Sumatera Barat' => [
                'Kota Padang', 'Kota Bukittinggi', 'Kota Payakumbuh', 'Kota Solok', 'Kota Sawahlunto',
                'Kota Padangpanjang', 'Kota Pariaman',
                'Agam', 'Padang Pariaman', 'Tanah Datar', 'Lima Puluh Kota', 'Pasaman', 'Pasaman Barat',
                'Solok', 'Solok Selatan', 'Dharmasraya', 'Sijunjung', 'Kepulauan Mentawai', 'Pesisir Selatan'
            ],
            'Riau' => [
                'Kota Pekanbaru', 'Kota Dumai',
                'Kampar', 'Pelalawan', 'Siak', 'Bengkalis', 'Rokan Hilir', 'Rokan Hulu',
                'Indragiri Hilir', 'Indragiri Hulu', 'Kuantan Singingi', 'Kepulauan Meranti'
            ],
            'Kepulauan Riau' => [
                'Kota Batam', 'Kota Tanjungpinang',
                'Bintan', 'Karimun', 'Natuna', 'Lingga', 'Kepulauan Anambas'
            ],
            'Jambi' => [
                'Kota Jambi', 'Kota Sungai Penuh',
                'Batanghari', 'Bungo', 'Kerinci', 'Merangin', 'Muaro Jambi', 'Sarolangun',
                'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tebo'
            ],
            'Bengkulu' => [
                'Kota Bengkulu',
                'Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara', 'Kaur', 'Kepahiang',
                'Lebong', 'Mukomuko', 'Rejang Lebong', 'Seluma'
            ],
            'Sumatera Selatan' => [
                'Kota Palembang', 'Kota Prabumulih', 'Kota Pagar Alam', 'Kota Lubuklinggau',
                'Banyuasin', 'Empat Lawang', 'Lahat', 'Muara Enim', 'Musi Banyuasin', 'Musi Rawas',
                'Musi Rawas Utara', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu',
                'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Penukal Abab Lematang Ilir'
            ],
            'Lampung' => [
                'Kota Bandar Lampung', 'Kota Metro',
                'Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara',
                'Mesuji', 'Pesawaran', 'Pesisir Barat', 'Pringsewu', 'Tanggamus', 'Tulang Bawang',
                'Tulang Bawang Barat', 'Way Kanan'
            ],
            'Bangka Belitung' => [
                'Kota Pangkalpinang',
                'Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Belitung', 'Belitung Timur'
            ],

            // JAWA
            'DKI Jakarta' => [
                'Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan', 'Jakarta Timur',
                'Kepulauan Seribu'
            ],
            'Jawa Barat' => [
                'Kota Bandung', 'Kota Bekasi', 'Kota Bogor', 'Kota Cimahi', 'Kota Cirebon', 'Kota Depok',
                'Kota Sukabumi', 'Kota Tasikmalaya', 'Kota Banjar',
                'Bandung', 'Bandung Barat', 'Bekasi', 'Bogor', 'Ciamis', 'Cianjur', 'Cirebon',
                'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Pangandaran', 'Purwakarta',
                'Subang', 'Sukabumi', 'Sumedang', 'Tasikmalaya'
            ],
            'Jawa Tengah' => [
                'Kota Semarang', 'Kota Surakarta', 'Kota Magelang', 'Kota Salatiga', 'Kota Pekalongan', 'Kota Tegal',
                'Banjarnegara', 'Banyumas', 'Batang', 'Blora', 'Boyolali', 'Brebes', 'Cilacap', 'Demak',
                'Grobogan', 'Jepara', 'Karanganyar', 'Kebumen', 'Kendal', 'Klaten', 'Kudus', 'Magelang',
                'Pati', 'Pekalongan', 'Pemalang', 'Purbalingga', 'Purworejo', 'Rembang', 'Semarang',
                'Sragen', 'Sukoharjo', 'Tegal', 'Temanggung', 'Wonogiri', 'Wonosobo'
            ],
            'DI Yogyakarta' => [
                'Kota Yogyakarta',
                'Bantul', 'Gunung Kidul', 'Kulon Progo', 'Sleman'
            ],
            'Jawa Timur' => [
                'Kota Surabaya', 'Kota Malang', 'Kota Kediri', 'Kota Blitar', 'Kota Madiun', 'Kota Mojokerto',
                'Kota Pasuruan', 'Kota Probolinggo', 'Kota Batu',
                'Bangkalan', 'Banyuwangi', 'Blitar', 'Bojonegoro', 'Bondowoso', 'Gresik', 'Jember', 'Jombang',
                'Kediri', 'Lamongan', 'Lumajang', 'Madiun', 'Magetan', 'Malang', 'Mojokerto', 'Nganjuk',
                'Ngawi', 'Pacitan', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Probolinggo', 'Sampang', 'Sidoarjo',
                'Situbondo', 'Sumenep', 'Trenggalek', 'Tuban', 'Tulungagung'
            ],
            'Banten' => [
                'Kota Tangerang', 'Kota Tangerang Selatan', 'Kota Serang', 'Kota Cilegon',
                'Lebak', 'Pandeglang', 'Serang', 'Tangerang'
            ],

            // KALIMANTAN
            'Kalimantan Barat' => [
                'Kota Pontianak', 'Kota Singkawang',
                'Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak',
                'Melawi', 'Mempawah', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'
            ],
            'Kalimantan Tengah' => [
                'Kota Palangka Raya',
                'Barito Selatan', 'Barito Timur', 'Barito Utara', 'Gunung Mas', 'Kapuas', 'Katingan',
                'Kotawaringin Barat', 'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulang Pisau',
                'Seruyan', 'Sukamara'
            ],
            'Kalimantan Selatan' => [
                'Kota Banjarmasin', 'Kota Banjarbaru',
                'Balangan', 'Banjar', 'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah',
                'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin'
            ],
            'Kalimantan Timur' => [
                'Kota Balikpapan', 'Kota Samarinda', 'Kota Bontang',
                'Berau', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Mahakam Ulu',
                'Paser', 'Penajam Paser Utara'
            ],
            'Kalimantan Utara' => [
                'Kota Tarakan',
                'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'
            ],

            // SULAWESI
            'Sulawesi Utara' => [
                'Kota Manado', 'Kota Bitung', 'Kota Kotamobagu', 'Kota Tomohon',
                'Bolaang Mongondow', 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur',
                'Bolaang Mongondow Utara', 'Kepulauan Sangihe', 'Kepulauan Siau Tagulandang Biaro',
                'Kepulauan Talaud', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara',
                'Minahasa Utara'
            ],
            'Sulawesi Tengah' => [
                'Kota Palu',
                'Banggai', 'Banggai Kepulauan', 'Banggai Laut', 'Buol', 'Donggala', 'Morowali',
                'Morowali Utara', 'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Toli-Toli'
            ],
            'Sulawesi Selatan' => [
                'Kota Makassar', 'Kota Parepare', 'Kota Palopo',
                'Bantaeng', 'Barru', 'Bone', 'Bulukumba', 'Enrekang', 'Gowa', 'Jeneponto', 'Kepulauan Selayar',
                'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros', 'Pangkajene dan Kepulauan', 'Pinrang',
                'Sidenreng Rappang', 'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo'
            ],
            'Sulawesi Tenggara' => [
                'Kota Kendari', 'Kota Baubau',
                'Bombana', 'Buton', 'Buton Selatan', 'Buton Tengah', 'Buton Utara', 'Kolaka',
                'Kolaka Timur', 'Kolaka Utara', 'Konawe', 'Konawe Kepulauan', 'Konawe Selatan',
                'Konawe Utara', 'Muna', 'Muna Barat', 'Wakatobi'
            ],
            'Gorontalo' => [
                'Kota Gorontalo',
                'Boalemo', 'Bone Bolango', 'Gorontalo', 'Gorontalo Utara', 'Pohuwato'
            ],
            'Sulawesi Barat' => [
                'Majene', 'Mamasa', 'Mamuju', 'Mamuju Tengah', 'Pasangkayu', 'Polewali Mandar'
            ],

            // BALI DAN NUSA TENGGARA
            'Bali' => [
                'Kota Denpasar',
                'Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem', 'Klungkung', 'Tabanan'
            ],
            'Nusa Tenggara Barat' => [
                'Kota Mataram', 'Kota Bima',
                'Bima', 'Dompu', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara',
                'Sumbawa', 'Sumbawa Barat'
            ],
            'Nusa Tenggara Timur' => [
                'Kota Kupang',
                'Alor', 'Belu', 'Ende', 'Flores Timur', 'Kupang', 'Lembata', 'Malaka', 'Manggarai',
                'Manggarai Barat', 'Manggarai Timur', 'Nagekeo', 'Ngada', 'Rote Ndao', 'Sabu Raijua',
                'Sikka', 'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur', 'Timor Tengah Selatan',
                'Timor Tengah Utara'
            ],

            // MALUKU
            'Maluku' => [
                'Kota Ambon', 'Kota Tual',
                'Buru', 'Buru Selatan', 'Kepulauan Aru', 'Maluku Barat Daya', 'Maluku Tengah',
                'Maluku Tenggara', 'Maluku Tenggara Barat', 'Seram Bagian Barat', 'Seram Bagian Timur'
            ],
            'Maluku Utara' => [
                'Kota Ternate', 'Kota Tidore Kepulauan',
                'Halmahera Barat', 'Halmahera Selatan', 'Halmahera Tengah', 'Halmahera Timur',
                'Halmahera Utara', 'Kepulauan Sula', 'Pulau Morotai', 'Pulau Taliabu'
            ],

            // PAPUA
            'Papua' => [
                'Kota Jayapura',
                'Asmat', 'Biak Numfor', 'Boven Digoel', 'Deiyai', 'Dogiyai', 'Intan Jaya', 'Jayapura',
                'Jayawijaya', 'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya', 'Mamberamo Tengah',
                'Mappi', 'Merauke', 'Mimika', 'Nabire', 'Nduga', 'Paniai', 'Pegunungan Bintang', 'Puncak',
                'Puncak Jaya', 'Sarmi', 'Supiori', 'Tolikara', 'Waropen', 'Yahukimo', 'Yalimo'
            ],
            'Papua Barat' => [
                'Kota Sorong',
                'Fakfak', 'Kaimana', 'Manokwari', 'Manokwari Selatan', 'Maybrat', 'Pegunungan Arfak',
                'Raja Ampat', 'Sorong', 'Sorong Selatan', 'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama'
            ],
            'Papua Tengah' => [
                'Deiyai', 'Dogiyai', 'Intan Jaya', 'Mimika', 'Nabire', 'Paniai', 'Puncak'
            ],
            'Papua Pegunungan' => [
                'Jayawijaya', 'Lanny Jaya', 'Mamberamo Tengah', 'Nduga', 'Pegunungan Bintang',
                'Puncak Jaya', 'Tolikara', 'Yahukimo', 'Yalimo'
            ],
            'Papua Selatan' => [
                'Asmat', 'Boven Digoel', 'Mappi', 'Merauke'
            ],
        ];

        // Masukkan data kabupaten
        foreach ($kabupatenData as $provinsi => $kabupatenList) {
            if (!isset($provinsiIds[$provinsi])) continue;

            $parentProvinsi = Region::find($provinsiIds[$provinsi]);
            if (!$parentProvinsi) continue;

            // Koordinat base provinsi (approximate)
            $baseLat = $parentProvinsi->center_lat ?? 0;
            $baseLng = $parentProvinsi->center_lng ?? 0;

            foreach ($kabupatenList as $kabupaten) {
                Region::create([
                    'name' => $kabupaten,
                    'type' => 'kabupaten',
                    'parent_id' => $provinsiIds[$provinsi],
                    // Generate random koordinat di sekitar provinsi (approximate)
                    'center_lat' => $baseLat + (rand(-100, 100) / 100),
                    'center_lng' => $baseLng + (rand(-100, 100) / 100),
                ]);
            }
        }
    }
}