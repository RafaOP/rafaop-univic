<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $guarded = [];

    public function joinProfessor()
    {
        return DB::table('professors')
            ->join('telefones', $this->id, '=', 'telefones.professor_id')
            ->join('disciplina', $this->id, '=', 'disciplina.professor_id')
            ->select('professors.*', 'telefones.etiqueta', 'telefones.numero',
                     'disciplinas.sigla', 'disciplinas.nome as disc_nome', 'disciplinas.carga')
            ->get();
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function telefones()
    {
        return $this->hasMany(Telefone::class);
    }

    public function addTelefone($etiqueta, $numero)
    {
        $telefone = new Telefone;
        $telefone->professor_id = $this->id;
        $telefone->etiqueta = $etiqueta;
        $telefone->numero = $numero;
        $telefone->save();
    }
}
