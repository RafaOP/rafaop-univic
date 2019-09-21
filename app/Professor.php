<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $guarded = [];

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }
}
