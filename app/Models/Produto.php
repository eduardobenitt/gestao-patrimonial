<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'produto_id');
    }
}
