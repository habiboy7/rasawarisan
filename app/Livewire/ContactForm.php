<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class ContactForm extends Component
{
    #[Validate('required|min:3')]
    public $nama = '';
    
    #[Validate('required|email')]
    public $email = '';
    
    #[Validate('required|regex:/^([0-9\s\-\+\(\)]*)$/')]
    public $nomor = '';
    
    #[Validate('required|min:10')]
    public $pesan = '';

    public $showAlert = false;
    public $alertMessage = '';

    public function submit()
    {
        $this->validate();

        // Simpan ke database atau kirim email
        // Contoh: Contact::create([...]);
        
        $this->showAlert = true;
        $this->alertMessage = 'Pesan Anda berhasil dikirim!';
        
        $this->reset(['nama', 'email', 'nomor', 'pesan']);
    }

    public function closeAlert()
    {
        $this->showAlert = false;
    }

    public function mount()
    {
        // Auto hide alert setelah 5 detik jika ada
        if ($this->showAlert) {
            $this->dispatch('alert-timer');
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}