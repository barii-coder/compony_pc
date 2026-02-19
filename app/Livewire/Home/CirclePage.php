<?php

namespace App\Livewire\Home;

use App\Models\Message;
use Livewire\Component;

class CirclePage extends Component
{
    public function render()
    {
        $circleMesages = Message::query()->where('is_circle', 1)->orderBy('updated_at','desc')->get();
        return view('livewire.home.circle-page',compact('circleMesages'));
    }
}
