@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/docente">Gestión de Salas UTEM</a>
@stop

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px">


@include('Docente/menu')


<div class="col-sm-9">

   <p> <h2>Resultado de la consulta</h2></p>

            
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif

<div class="panel panel-default" style="margin-top: 15px">
<div class="panel-body">
  <div class="form-group">

          <table class="table table-striped">
            <tr> 
              <th>Campus</th>
              <th>Nombre</th>
              <th>Sala</th>
              <th>Período</th>
              <th>Hora</th>
               <th>Fecha</th>
              
            </tr>

            @foreach($resultados as $result)

            <tr>
               <td>{{ $result->campus}}</td>
               <td>{{ $result->nombre}}</td>
               <td>{{ $result->sala}}</td>
               <td>{{ $result->bloque}}</td>
               <td>{{ $result->inicio}} - {{$result->fin}}</td>
               <td>{{ $result->fecha}}</td>
            </tr>

             @endforeach

          </table>
          {!! $resultados->render() !!}
     
                
</div>
</div>
                  
</div>
</div>
</div>
      

@stop
	