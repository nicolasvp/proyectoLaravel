@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/administrador">Gestión de Salas UTEM</a>
@stop



@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">
                         
@include('Administrador/menu')
  



  <div class="col-sm-9">
                
<div class="panel panel-default" style="margin-top: 15px">
<div class="panel-body">
  <div class="form-group">
  <div class="jumbotron">

    <p class="lead">
   <h3 align="center"> 
    <b>
    Como administrador podrá acceder a toda la información disponible del sistema, 
    como también crear, modificar y eliminar datos desde el Menú Administrador disponible.
    </b>
    </h3></p>

       @if(Session::has('message'))
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif




    </div>
  </div>

        
</div>

                    
</div>

</div>
</div>
</div>
@stop