<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academico extends Model
{
    use HasFactory;
    protected $fillable = [
        'matricula',
        'grupo_id',
        'estatus',
        'version',
        'formato',
        'user_id',
        'profesor_id',
        'periodo_id',
        'numero',
       ];

       public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
