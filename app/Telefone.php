<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $guarded = [];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
