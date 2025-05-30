<?php

namespace App\Traits;

use App\Models\Chat\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin User
*/
trait CanHaveConversation
{
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(
            Conversation::class,
            'conversation_users',
            'user_id',
            'conversation_id'
        )->withPivot('user_id', 'conversation_id');
    }
}
