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
        return view('disciplinas.index', ['disciplinas' => Disciplina::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('disciplinas.create', ['professores' => Professor::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'nome' => ['required'],
            'sigla' => ['required'],
            'carga' => ['required'],
            'professor_id' => []
        ]);
        Disciplina::create($attributes);

        return redirect('/disciplinas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function show(Disciplina $disciplina)
    {
        return view('disciplinas.show', compact('disciplina'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function edit(Disciplina $disciplina)
    {
        $professores = Professor::all();
        return view('disciplinas.edit', compact('disciplina', 'professores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disciplina $disciplina)
    {
        $disciplina->update(request(['nome','sigla', 'carga', 'professor_id']));

        return redirect('/disciplinas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return redirect('disciplinas');
    }
}
