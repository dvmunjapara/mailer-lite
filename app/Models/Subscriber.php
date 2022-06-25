<?php

namespace App\Models;

use App\Enums\SubscriberStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'name', 'status'];

    protected $casts = [
        'status' => SubscriberStatus::class
    ];

    public function fields() {

        return $this->belongsToMany(Field::class)->withPivot('value');
    }
}
