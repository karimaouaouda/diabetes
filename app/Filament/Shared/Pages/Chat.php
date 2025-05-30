<?php

namespace App\Filament\Shared\Pages;

use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';

    protected static string $view = 'filament.pages.chat';

    // Titre de la page
    protected static ?string $title = 'Chat';

    // Appear in the menu
    protected static ?string $navigationGroup = 'Communication';

    // Position dans le menu de la barre latérale
    protected static ?int $navigationSort = 2;

    public int $count = 0;

    public function increament(): void
    {
        $this->count++;
    }
}
