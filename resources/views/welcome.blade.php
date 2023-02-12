<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <!-- Styles -->


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
@if(!empty($news))
<h1>Новости</h1>
<div style="display: flex; flex-wrap: wrap;justify-content: space-between">


    @foreach($news as $new)

        <div class="card ml-2" style="width: 18rem;  display: flex; flex-direction: row; justify-content: space-between"  >
            <div class="card-body">
                <h5 class="card-title">{{$new->title}}</h5>
                <p class="card-text">Категория:{{$new->category}}</p>
                <p class="card-text">{{$new->description}}</p>
                @if(!empty($new->author))
                <p class="card-text">Автор:{{$new->author}}</p>
                @endif
                <a href="{{$new->link}}">Сылка</a>
                <p class="card-text">Дата:{{$new->date}}</p>

            </div>
        </div>


    @endforeach
</div>
<div class="col-md-5">
    {{$news->links('vendor.pagination.bootstrap-4') }}
</div>
@else
    <h1>Новостей пока нет...</h1>
@endif
    </body>
</html>
