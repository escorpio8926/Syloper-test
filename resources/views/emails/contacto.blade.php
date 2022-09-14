@extends('layouts.app')
@section('content')

<div class="contanier my-5 padre" >
    <form id="formulario" action="/sendEmail" method="get">
        <h1 style="color: darkslategrey ;font-size: revert"><em>FORMULARIO DE CONTACTO</em></h1><br>
        <label for="Motivo"><b>Motivo:</b></label>
        <input type="text" id="Motivo" name="Motivo" class="form-control my-1" required><br><br>
        <label for="descripcion"><b>Descripcion:</b></label>
        <input type="text" id="descripcion" name="descripcion" class="form-control my-1" required><br><br>
        <label for="mail"><b>Mail:</b></label>
        <input type="text" id="email" name="mail" class="form-control my-1" placeholder="destinatario@gmail.com" required><br><br>
        <input type="submit" value="Enviar" class="btn btn-light" style="margin-left: 35%;background-color:aliceblue" >
        </div>
    </form>
</div>

@endsection

