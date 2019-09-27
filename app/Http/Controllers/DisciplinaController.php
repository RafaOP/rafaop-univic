<?php

namespace App\Http\Controllers;

use App\Disciplina;
use App\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplinaController extends Controller
{
    /**
     * Retorna uma lista de todas as disciplinas.
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
     * Retorna todas as disciplinas que não possuem um professor.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFatherless()
    {
        return DB::table('disciplinas')->where('professor_id', null)->get();
    }

    /**
     * Amazena uma nova disciplina no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'nome' => ['required', 'max:255'],
            'sigla' => ['required', 'max:255', 'unique:disciplinas'],
            'carga' => ['required'],
            'professor_id' => []
        ]);

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
        $attributes = request()->validate([
            'nome' => ['required', 'max:255'],
            'sigla' => ['required', 'max:255'],
            'carga' => ['required'],
            'professor_id' => []
        ]);

        $disciplina = Disciplina::findOrFail(request('id'));
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
