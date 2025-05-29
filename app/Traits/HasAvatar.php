<?php

namespace App\Traits;

/**
 * @mixin \App\Models\User
*/
trait HasAvatar
{
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?? 'https://i.pravatar.cc/150?u=' . $this->getAttribute('id') .'?d=mp';
    }

}
