@extends('../layout')
@section('title', 'Professores')

@section('content')
    <h1 class="title">Professores</h1>
    <ul>
        @foreach ($professores as $professor)
            <li><a href="/professores/{{ $professor->id }}">{{ $professor->nome }}</a></li>
        @endforeach
    </ul>
@endsection