@extends('../layout')
@section('title', 'Professor '.explode(' ', $professor->nome)[0])

@section('content')
    <h1>{{ $professor->nome }}</h1>
    <p>Matrícula: {{ $professor->matricula }}</p>
    <p>Email: {{ $professor->email }}</p>
    <p>Data de nascimento: {{ $professor->data_nasc }}</p>
    <p>Registrado em {{ $professor->created_at }}</p>
    <p>Ultima alteração realizada em {{ $professor->updated_at }}</p>

    @if ($professor->disciplinas->count())
        <h2>Esse professor leciona as seguintes disciplinas</h2>
        @foreach ($professor->disciplinas as $disciplina)
            <p>{{ $disciplina->sigla }} - {{ $disciplina->nome }} ({{ $disciplina->carga }}h semanais)</p>
        @endforeach
    @else
        <p>Esse professor não leciona nenhuma disciplina</p>
    @endif
@endsection