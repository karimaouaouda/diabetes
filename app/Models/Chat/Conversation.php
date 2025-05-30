<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    /** @use HasFactory<\Database\Factories\ConversationFactory> */
    use HasFactory;



    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function members(): BelongsToMany
    {
        $this->belongsToMany(
            User::class,
            'conversation_users',
        'conversation_id',
        'user_id'
        )->withPivot(['joined_at']);
    }
}
