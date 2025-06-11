<div wire:poll.5s="updateUnreadMessagesCount">
    <x-filament::link :href="route('chatify')" >
        <x-filament::icon-button
            :badge="$unreadMessagesCount ?: null"
            color="gray"
            icon="heroicon-o-chat-bubble-left-right"
            icon-alias="panels::topbar.open-database-notifications-button"
            icon-size="lg"
            :label="__('messages')"
            class="fi-topbar-database-notifications-btn"
        />

    </x-filament::link>
</div>
