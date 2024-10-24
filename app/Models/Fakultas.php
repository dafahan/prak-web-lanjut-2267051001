<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;
    protected $table = 'fakultas';

    // Specify which attributes can be mass-assigned
    protected $fillable = ['nama'];

    // Define the relationship between Fakultas and User (One Fakultas has many Users)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
