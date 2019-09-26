<?php

namespace App\Http\Controllers;

use App\Disciplina;
use App\Professor;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Disciplina::all();
    }

    public function getOne(Request $request)
    {
        return Disciplina::findOrFail(request('id'));
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
            'nome' => request('disciplina.nome'),
            'sigla' => request('disciplina.sigla'),
            'carga' => request('disciplina.carga'),
            'professor_id' => request('disciplina.professor_id')
        ];

        Disciplina::create($attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $attributes = [
            'nome' => request('disciplina.nome'),
            'sigla' => request('disciplina.sigla'),
            'carga' => request('disciplina.carga'),
            'professor_id' => request('disciplina.professor_id')
        ];

        $disciplina = Disciplina::findOrFail(request('disciplina.id'));
        $disciplina->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $disciplina = Disciplina::findOrFail(request('id'));
        $disciplina->delete();
    }
}
