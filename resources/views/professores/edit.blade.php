@extends('../layout')
@section('title', 'Editar professor')

@section('content')
    <form method="POST" action="/professores/{{ $professor->id }}">
        @method('PATCH')
        @csrf

        <div>
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="{{ $professor->nome }}">
        </div>

        <div>
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" value="{{ $professor->matricula }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email" value="{{ $professor->email }}">
        </div>

        <div>
            <label for="data_nasc">Data de nascimento</label>
            <input type="date" name="data_nasc" value="{{ $professor->data_nasc }}">
        </div>

        <div><button type="submit">Salvar</button></div>
    </form>

    <form method="POST" action="/professores/{{ $professor->id }}">
        @method('DELETE')
        @csrf

        <div class="field">
            <div class="control">
                <button type="submit" class="button">Excluir registro</button>
            </div>
        </div>
    </form>
@endsection