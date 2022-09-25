@extends('layouts.app')
@section('content')

<div class="contanier my-5 padre" >
    <form id="formulario" action="/upost/{{ $post->user_id }}" method="post" enctype="multipart/form-data">
    @csrf
        <h1 style="color: darkslategrey ;font-size: revert"><em>MODIFICAR POST</em></h1>
        <br>
        <label for="select"><b>Categoria:</b></label><br>
        <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th><b>Categoria</b></th>
                            <th>Categoria Padre</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($categorys))
                            <?php $_SESSION['i'] = 0; ?>
                            @foreach($categorys as $category)
                                <tr>
                                    <?php $dash=''; ?>
                                    <td><strong>{{$category->descripcion}}</strong></td>
                                    <td>

                                    </td>
                                 </tr>
                                 @if(count($category->subcategory))
                                     @include('sub-category-list',['subcategories' => $category->subcategory])
                                 @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>      
        <label style="color:red"><b>(Las categorias se deben dar de alta por medio de la API)</b></label>
        <br>
        <br>
        <label for="titulo"><b>Tìtulo:</b></label>
        <input type="text" id="titulo" name="titulo" class="form-control my-1" value='{{ $post->titulo }}'  required><br>
        <label><b>Imagen Actual</b></label><br>
        <img src="{{ asset($post->imagen) }}" width="100" height="100"><br><br>
        <label for="imagen"><b>Seleccione una imagen:</b></label><br>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>
        <label for="descripcion"><b>Descripcion:</b></label>
        <input type="text" id="descripcion" name="descripcion" class="form-control my-1" value='{{ $post->descripcion }}' required><br><br>
        <input type="hidden" id="user_id" name="user_id" class="form-control my-1" value='{{ Auth::user()->id }}' required>
        <input type="hidden" id="id" name="id" class="form-control my-1" value='{{ $post->id }}' required>
        <input type="submit" value="Modificar" class="btn btn-light" style="margin-left: 35%;">

        </div>
        @error('imagen')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    </form>
</div>
@endsection

