<?php

namespace App\Livewire;

use App\Models\ChMessage;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ChatIcon extends Component
{

    public int $unreadMessagesCount = 1;

    public function increment(): void
    {
        $this->unreadMessagesCount += 1;
    }

    public function getUnreadMessagesQuery(){
        return ChMessage::query()
            ->where(function (Builder $query){
                $query->where('from_id', auth()->id())
                    ->orWhere('to_id', auth()->id());
            })->where('seen', false);
    }

    public function updateUnreadMessagesCount(): void
    {
        $this->unreadMessagesCount = $this->getUnreadMessagesQuery()->count();
    }

    public function mount(): void
    {
    }

    public function render()
    {
        return view('livewire.chat-icon', [
            'unreadMessagesCount' => $this->unreadMessagesCount
        ]);
    }
}
