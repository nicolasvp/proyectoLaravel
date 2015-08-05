@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/alumno">Gestión de Salas UTEM</a>
@stop

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px">

@include('Estudiante/menu')


<div class="col-sm-9">

   <p> <h2>Tus cursos</h2></p>

            
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif

<div class="panel panel-default" style="margin-top: 15px">
<div class="panel-body">
  <div class="form-group">
    <p><h3>Lunes</h3></p>
          <table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_lunes as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>
    <p><h3>Martes</h3></p>       
            <table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_martes as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>
        <p><h3>Miércoles</h3></p>
        <table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_miercoles as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>
           <p><h3>Jueves</h3></p>
           <table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_jueves as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>

           <p><h3>Viernes</h3></p>
           <table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_viernes as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>

           <p><h3>Sábado</h3>
           </p><table class="table table-striped">
            <tr> 
              
              <th>Asignatura</th>
              <th>Sala</th>
              <th>Hora</th>
              <th>Día</th>
              
            </tr>

            @foreach($datos_sabado as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->fecha}}</td>
            </tr>

             @endforeach

          </table>
    
                
</div>
</div>
                  
</div>
</div>
</div>
      

@stop