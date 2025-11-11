<?php

namespace App\Livewire;

use Livewire\Component;

class FavoriteRestaurant extends Component
{
    public $favoriteRestaurant = [];
    public $currentPage = 0;
    public $itemsPerPage = 3;


    // menerima $foods saat mounting dari parent view
    public function mount($favoriteRestaurant = [])
    {
        $this->favoriteRestaurant = $favoriteRestaurant;
    }

    public function nextPage()
    {
        $safeRestaurant = (array) ($this->favoriteRestaurant ?? []);
        $totalPages = ceil(count($safeRestaurant) / $this->itemsPerPage);
        $this->currentPage = ($this->currentPage + 1) % max(1, $totalPages);
    }

    public function render()
    {
        $safeRestaurant = (array) ($this->favoriteRestaurant ?? []);
        $start = $this->currentPage * $this->itemsPerPage;
        $pageRestaurant = array_slice($safeRestaurant, $start, $this->itemsPerPage);
        $totalPages = ceil(count($safeRestaurant) / $this->itemsPerPage);

        return view('livewire.favorite-restaurant', [
            'pageRestaurant' => $pageRestaurant ?? [],
            'totalPages' => $totalPages ?? 0,
            'currentPage' => $this->currentPage ?? 0,
        ]);
    }
}
