<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_name',
        'client_phone',
        'worker_id',
        'reservation_date',
        'estimated_duration',
        'status',
        'notes',
        'work_area'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function reservationServices()
    {
        return $this->hasMany(ReservationService::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['date_from'])) {
            $query->where('reservation_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('reservation_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['worker_id'])) {
            $query->where('worker_id', $filters['worker_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
