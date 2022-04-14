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
        <h1 class="mt-5 mb-3">Сайт: {{ $url->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $url->id }}</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>{{ $url->name }}</td>
                    </tr>
                    <tr>
                        <td>Дата создания</td>
                        <td>{{ $url->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Проверки</h2>
        <form class="mb-3" method="POST" action="#">
            @csrf

            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>h1</th>
                <th>title</th>
                <th>description</th>
                <th>Дата создания</th>
            </tr>
            <tr>
                <td>{{ $url->id }}</td>
{{--                    todo код ответа--}}
                <td>Код ответа</td>
{{--                    todo h1--}}
                <td>h1</td>
{{--                    todo title--}}
                <td>title</td>
{{--                    todo description--}}
                <td>description</td>
                <td>{{ $url->updated_at }}</td>
            </tr>
        </table>
    </div>
@endsection
