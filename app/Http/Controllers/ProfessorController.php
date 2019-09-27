<?php

namespace App\Http\Controllers;

use App\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Response;

class ProfessorController extends Controller
{
    /**
     * Retorna uma lista com todos os professores.
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

    /**
     * Retorna um professor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOne(Request $request)
    {
        return Professor::findOrFail(request('id'));
    }

    /**
     * Amazena um novo professor no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'nome' => ['required', 'max:255'],
            'matricula' => ['required', 'max:255', 'unique:professors'],
            'data_nasc' => ['required'],
            'email' => ['required', 'min:5', 'max:255', 'unique:professors']
        ]);

        $professor = new Professor($attributes);
        $professor->save();

        $telefones = request('telefones');
        foreach ($telefones as $tel)
            $professor->addTelefone($tel['principal'], $tel['etiqueta'], $tel['numero']);
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
        $attributes = request()->validate([
            'nome' => ['required', 'max:255'],
            'matricula' => ['required', 'max:255'],
            'data_nasc' => ['required'],
            'email' => ['required', 'min:5', 'max:255']
        ]);

        $professor = Professor::findOrFail(request('id'));
        $professor->update($attributes);

        // Apaga todos os telefones do professor
        $telefones = DB::table('telefones')
                        ->where('professor_id', '=', $professor->id)
                        ->delete();

        // Adiciona novamente os telefones
        $telefones = request('telefones');
        foreach($telefones as $tel)
            $professor->addTelefone($tel['principal'], $tel['etiqueta'], $tel['numero']);
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
