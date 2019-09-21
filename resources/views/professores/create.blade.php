@extends('../layout')
@section('title', 'Adicionar professor')

@section('content')
    <form method="POST" action="/professores">
        @csrf

        <div>
            <label for="nome">Nome</label>
            <input type="text" name="nome">
        </div>

        <div>
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email">
        </div>

        <div>
            <label for="data_nasc">Data de nascimento</label>
            <input type="date" name="data_nasc">
        </div>

        <div><button type="submit">Adicionar</button></div>
    </form>
@endsection