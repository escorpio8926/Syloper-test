@extends('layouts.app')
@section('content')

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Categoria</th>
      <th scope="col">Titulo</th>
      <th scope="col">Slug</th>
      <th scope="col">Imagen</th>
      <th scope="col">Descripcion</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach ($posts as $post)
    <tr>
      <th scope="row">{{ $post->id }}</th>
      <th scope="row">{{ $post->categoria }}</th>
      <td>{{ $post->slug }}</td>
      <td> <img src="{{ url($post->imagen) }}" width="100" height="100"></td>
      <td>{{$post->descripcion }}</td>
      <td>
      <a href="/post/{{ $post->slug }}"><button type="button" class="btn btn-primary">Editar</button></a>
      <a href="/dpost/{{ $post->id }}/{{ $post->user_id }}"><button type="button" class="btn btn-danger">Eliminar</button></a>
    </td>

    </tr>
    @endforeach
  </tbody>
</table>

{{ $posts->links() }}
@endsection
