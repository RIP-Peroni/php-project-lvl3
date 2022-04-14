@extends('layout.app')

@section('title', 'Анализатор страниц')

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
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
            @foreach($urls as $url)
                <tr>
                    <th scope="row">{{ $url->id }}</th>
                    <td>
                        <a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a>
                    </td>
                    <td>{{ $url->updated_at }}</td>
{{--                    todo:--}}
                    <td>код ответа</td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
    <div class="container-lg">
        {{ $urls->links() }}
    </div>
@endsection