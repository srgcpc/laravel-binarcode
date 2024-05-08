<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Scheduler extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'channel',
        'message',
        'time',
        'email',
    ];

    public function scopeReady(Builder $query): void
    {
        $query->where('sent_at', null);
    }
}
