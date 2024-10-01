<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccomplishmentReport extends Model
{
    protected $fillable = [
        'user_id', 'account', 'task', 'particulars', 'start_time', 'end_time', 'hours'
    ];
}
