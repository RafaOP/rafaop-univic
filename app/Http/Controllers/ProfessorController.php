<?php

namespace App\Http\Controllers;

use App\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professores = Professor::all();
        $collection = [];
        $i = 0;
        foreach ($professores as $professor) {
            array_push($collection, $professor);
            $collection[$i]->telefones = $professor->telefones;
            $collection[$i]->disciplinas = $professor->disciplinas;
            ++$i;
        }
        return $collection;
    }

    public function getOne(Request $request)
    {
        return Professor::findOrFail(request('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = [
            'nome' => request('professor.nome'),
            'matricula' => request('professor.matricula'),
            'data_nasc' => request('professor.data_nasc'),
            'email' => request('professor.email')
        ];

        $professor = new Professor($attributes);
        $professor->save();

        for ($i = 0; $i < count(request('professor.etiquetas')); ++$i)
            $professor->addTelefone(request('professor.etiquetas')[$i], request('professor.telefones')[$i]);

        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $attributes = [
            'nome' => request('professor.nome'),
            'matricula' => request('professor.matricula'),
            'data_nasc' => request('professor.data_nasc'),
            'email' => request('professor.email')
        ];

        $professor = Professor::findOrFail(request('professor.id'));
        $professor->update($attributes);

        for ($i = 0; $i < count(request('professor.etiquetas')); ++$i)
            $professor->addTelefone($professor->id, request('professor.etiquetas')[$i], request('professor.telefones')[$i]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $professor = Professor::findOrFail(request('id'));
        $professor->delete();
    }
}
