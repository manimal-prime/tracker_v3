<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    /**
     * relationship - position has many member
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function history()
    {
        return $this->morphMany(MemberHistory::class, 'trackable');
    }
}
