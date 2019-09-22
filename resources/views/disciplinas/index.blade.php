@extends('../layout')
@section('title', 'Disciplinas')

@section('content')
    <h1 class="title">Disciplinas</h1>
    <ul>
        @foreach ($disciplinas as $disciplina)
            <li><a href="/disciplinas/{{ $disciplina->id }}">{{ $disciplina->sigla }} - {{ $disciplina->nome }}</a></li>
        @endforeach
    </ul>
@endsection