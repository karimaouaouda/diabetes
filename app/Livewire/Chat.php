<?php

namespace App\Livewire;

use App\Models\Chat\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{

    public Conversation $conversation;

    public User $user;

    public function mount(){
        $this->user = Auth::user();

        $this->conversation = $this->user->conversations()->latest()->first();
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
