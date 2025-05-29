<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

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
}
