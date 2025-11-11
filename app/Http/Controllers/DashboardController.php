<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $favoriteFoods = [
            [
                'name' => 'Gudeg Manggar',
                'location' => 'Yogyakarta, Indonesia',
                'likes' => 4000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Soto Kudus',
                'location' => 'Kudus, Indonesia',
                'likes' => 3200,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rawon',
                'location' => 'Surabaya, Indonesia',
                'likes' => 2800,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Pempek',
                'location' => 'Palembang, Indonesia',
                'likes' => 3100,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Nasi Liwet',
                'location' => 'Solo, Indonesia',
                'likes' => 2900,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
            [
                'name' => 'Rendang',
                'location' => 'Padang, Indonesia',
                'likes' => 5000,
                'image' => 'images/gambar6.png'
            ],
        ];

        $favoriteRestaurant = [
            [ 
                'region_selected' => 'Yogyakarta',
                'name' => 'Warung Makan Sederhana',
                'location' => 'Yogyakarta, Indonesia',
                'likes' => 1500,
                'image' => 'images/gambar6.png'
            ],
            [
                'region_selected' => 'Kudus',
                'name' => 'Depot Soto Kudus Pak Slamet',
                'location' => 'Kudus, Indonesia',
                'likes' => 1200,
                'image' => 'images/gambar6.png'
            ],
            [
                'region_selected' => 'Surabaya',
                'name' => 'Rumah Makan Rawon Setan',
                'location' => 'Surabaya, Indonesia',
                'likes' => 1100,
                'image' => 'images/gambar6.png'
            ],
            [
                'region_selected' => 'Palembang',
                'name' => 'Pempek Beringin',
                'location' => 'Palembang, Indonesia',
                'likes' => 1300,
                'image' => 'images/gambar6.png'
            ],
            [
                'region_selected' => 'Solo',
                'name' => 'Nasi Liwet Bu Wongso',
                'location' => 'Solo, Indonesia',
                'likes' => 1250,
                'image' => 'images/gambar6.png'
            ],
        ];

        return view('dashboard', compact('favoriteFoods', 'favoriteRestaurant'));
    }
}
