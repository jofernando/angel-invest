<?php

namespace App\Http\Livewire;

use App\Models\Proposta;
use Livewire\Component;

class Likes extends Component
{
    public $curtiu;
    public $likes;

    public function mount(Proposta $proposta)
    {
        $this->proposta = $proposta;
        $this->likes = $proposta->likes()->count();
        if (auth()->check()) {
            $this->curtiu = $proposta->likes()->where('user_id', auth()->user()->id)->exists();
        } else {
            $this->curtiu = false;
        }
    }

    public function curtir()
    {
        $this->proposta->likes()->attach(auth()->user()->id);
        $this->likes = $this->proposta->likes()->count();
        $this->curtiu = true;
    }

    public function descurtir()
    {
        $this->proposta->likes()->detach(auth()->user()->id);
        $this->likes = $this->proposta->likes()->count();
        $this->curtiu = false;
    }

    public function render()
    {
        return view('livewire.likes');
    }
}
