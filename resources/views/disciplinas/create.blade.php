@extends('../layout')
@section('title', 'Adicionar disciplina')

@section('content')
    <form method="POST" action="/disciplinas">
        @csrf

        <div>
            <label for="nome">Nome</label>
            <input type="text" name="nome">
        </div>

        <div>
            <label for="sigla">Sigla</label>
            <input type="text" name="sigla">
        </div>

        <div>
            <label for="carga">Carga horária</label>
            <input type="number" name="carga">
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

        <div><button type="submit">Adicionar</button></div>
    </form>
@endsection