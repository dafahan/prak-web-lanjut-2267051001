<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $guarded = ['id'];

    protected $fillable = ['nama', 'kelas_id', 'jurusan', 'semester', 'fakultas_id', 'foto'];

    // Define the relationship between User and Fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
    
    public function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
}
