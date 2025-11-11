<?php

namespace App\Livewire;

use Livewire\Component;

class FavoriteFoods extends Component
{
    public $favoriteFoods = [];
    public $currentPage = 0;
    public $itemsPerPage = 5;


    // menerima $foods saat mounting dari parent view
    public function mount($favoriteFoods = [])
    {
        $this->favoriteFoods = $favoriteFoods;
    }

    public function nextPage()
    {
        $safeFoods = (array) ($this->favoriteFoods ?? []);
        $totalPages = ceil(count($safeFoods) / $this->itemsPerPage);
        $this->currentPage = ($this->currentPage + 1) % max(1, $totalPages);
    }

    public function render()
    {
        $safeFoods = (array) ($this->favoriteFoods ?? []);
        $start = $this->currentPage * $this->itemsPerPage;
        $pageFoods = array_slice($safeFoods, $start, $this->itemsPerPage);
        $totalPages = ceil(count($safeFoods) / $this->itemsPerPage);

        return view('livewire.favorite-foods', [
            'pageFoods' => $pageFoods ?? [],
            'totalPages' => $totalPages ?? 0,
            'currentPage' => $this->currentPage ?? 0,
        ]);
    }
}
