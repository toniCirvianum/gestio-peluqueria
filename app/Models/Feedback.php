<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'worker_id', 'service_id', 'reservation_id', 'rating', 'comment'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
