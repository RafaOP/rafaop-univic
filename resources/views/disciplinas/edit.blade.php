@extends('../layout')
@section('title', 'Editar disciplina')

@section('content')
    <form method="POST" action="/disciplinas/{{ $disciplina->id }}">
        @method('PATCH')
        @csrf

        <div>
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="{{ $disciplina->nome }}">
        </div>

        <div>
            <label for="sigla">Sigla</label>
            <input type="text" name="sigla" value="{{ $disciplina->sigla }}">
        </div>

        <div>
            <label for="carga">Carga horária</label>
            <input type="number" name="carga" value="{{ $disciplina->carga }}">
        </div>

        @if($professores->count())
            <div>
                <label for="professor">Associar a professor</label>
                <input list="professor" name="professor_id">
                <datalist id="professor">
                    @foreach($professores as $professor)
                        <option value={{ $professor->id }}>{{ $professor->nome }}</option>
                    @endforeach
                </datalist>
            </div>
        @endif

        <div><button type="submit">Salvar</button></div>
    </form>

    <form method="POST" action="/disciplinas/{{ $disciplina->id }}">
        @method('DELETE')
        @csrf

        <div class="field">
            <div class="control">
                <button type="submit" class="button">Excluir disciplina</button>
            </div>
        </div>
    </form>
@endsection