<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'job_id', 'status', 'applied_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job_listings()
    {
        return $this->belongsTo(job_listings::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
