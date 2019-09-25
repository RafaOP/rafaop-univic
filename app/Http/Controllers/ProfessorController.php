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

    /**
     * Show the form for creating a new resource.
     * NOT USED
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

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
            $professor->addTelefone($professor->id, request('professor.etiquetas')[$i], request('professor.telefones')[$i]);
    }

    /**
     * Display the specified resource.
     * NOT USED
     *
     * @param  \App\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     * NOT USED
     *
     * @param  \App\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}

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
        // ----------------------------------------
        $professor = Professor::findOrFail($id);
        $attributes = request()->validate([
            'nome' => ['required'],
            'matricula' => ['required'],
            'data_nasc' => ['required'],
            'email' => ['required']
        ]);
        $professor->update($attributes);
        return redirect('professores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->delete();
        return redirect('professores');
    }
}
