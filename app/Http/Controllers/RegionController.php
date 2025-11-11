<?php

namespace App\Http\Controllers;

use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Menampilkan daftar semua pulau.
     */
    public function index()
    {
        $pulau = Region::where('type', 'pulau')->get();

        return view('regions.index', compact('pulau'));
    }

    /**
     * Menampilkan provinsi berdasarkan pulau yang diklik.
     */
    public function show($slug)
    {
        // Ambil data pulau berdasarkan slug
        $pulau = Region::where('slug', $slug)->firstOrFail();

        // Ambil provinsi yang parent-nya adalah pulau tersebut
        $provinsi = Region::where('parent_id', $pulau->id)->get();

        return view('regions.show', compact('pulau', 'provinsi'));
    }
}
