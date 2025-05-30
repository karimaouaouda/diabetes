<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function images(): array
    {
        if($this->getAttribute('files') == NULL){
            return [];
        }
        $images = [];
        foreach ($this->getAttribute('files') as $file){
            if(getimagesize($file)){
                $images[] = $file;
            }
        }

        return $images;
    }

    public function documents(): array
    {
        if($this->getAttribute('files') == NULL){
            return [];
        }

        $documents = [];

        foreach ($this->getAttribute('files') as $file){
            if(!getimagesize($file)){
                $documents[] = $file;
            }
        }

        return $documents;
    }


    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
