<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHandle extends Model
{
    use HasFactory;

    protected $table = 'handle_member';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function handle()
    {
        return $this->belongsTo(Handle::class);
    }

    public function division()
    {
        return $this->hasOneThrough(
            Division::class,
            Member::class,
            'id',
            'id',
            'member_id',
            'division_id'
        );
    }
}
