<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $guarded = [];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
