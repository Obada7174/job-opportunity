<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'description', 'company_capacity', 'industry', 'working_hours', 'image_path', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job_listings()
    {
        return $this->hasMany(job_listings::class);
    }
}