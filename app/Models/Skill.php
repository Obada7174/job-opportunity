<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // علاقة many-to-many مع User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function jobListings()
    {
        return $this->belongsToMany(JobListing::class);
    }
}