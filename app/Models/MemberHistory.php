<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    protected $with = ['admin'];

    protected $table = 'member_history';

    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trackable()
    {
        return $this->morphTo();
    }

    public function admin()
    {
        return $this->belongsTo(Member::class);
    }
}
