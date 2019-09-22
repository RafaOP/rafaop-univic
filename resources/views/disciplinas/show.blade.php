@extends('../layout')
@section('title', 'Disciplina '.$disciplina->sigla)

@section('content')
    <h1>{{ $disciplina->sigla }} - {{ $disciplina->nome }}</h1>
    <p>Carga horária de {{ $disciplina->carga }}h semanais</p>
    <p>Registrada em {{ $disciplina->created_at }}</p>
    <p>Ultima alteração realizada em {{ $disciplina->updated_at }}</p>

    @if ($disciplina->professor)
        <h2>
            Essa disciplina é lecionada pelo professor 
            <a href="/professores/{{ $disciplina->professor->id }}">
                {{ $disciplina->professor->nome }}
            </a>
        </h2>
    @else
        <p>Essa disciplina ainda não está associada a nenhum professor. <a href="/disciplinas/{{ $disciplina->id }}/edit">Associar agora?</a></p>
    @endif
@endsection