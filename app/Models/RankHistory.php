<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankHistory extends Model
{
    protected $table = 'rank_history';

    protected $guarded = [];

    protected $with = [
        'rank',
        'member'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function admin()
    {
        return $this->belongsTo(Member::class);
    }
}
