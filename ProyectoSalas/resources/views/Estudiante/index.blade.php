@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/alumno">Gestión de Salas UTEM</a>
@stop

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px">

@include('Estudiante/menu')


         <div class="col-sm-9">
            
<div class="panel panel-default" style="margin-top: 15px">
<div class="panel-body">
  <div class="form-group">
  <div class="jumbotron">

        <p class="lead">
         <h3 align="center"> 
          <b>
         Estimado estudiante, en este sistema usted podrá revisar las salas asignadas a sus cursos, como también consultar por un horario en particular.
          </b>
          </h3>
        </p>

   
     
    </div>
                
</div>
</div>
                  
</div>
</div>
</div>
      

@stop