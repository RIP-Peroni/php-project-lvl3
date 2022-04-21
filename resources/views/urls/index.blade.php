@extends('layout.app')

@section('title', 'Анализатор страниц')

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
@endif

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Последняя проверка</th>
                <th scope="col">Код ответа</th>
            </tr>
            @if($urls)
                @foreach($urls as $url)
                    <tr>
                        <th scope="row">{{ $url->id }}</th>
                        <td>
                            <a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a>
                        </td>
                        <td>{{ $lastChecks[$url->id]->updated_at ?? '' }}</td>
                        <td>{{ $lastChecks[$url->id]->status_code ?? '' }}</td>
                    </tr>
                @endforeach
            @endif
        </table>
        </div>
    </div>
    <div class="container-lg">
        {{ $urls->links() }}
    </div>
@endsection
