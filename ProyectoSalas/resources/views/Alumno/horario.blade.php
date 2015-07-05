@extends('layouts/master')



@section('sideBar')

@include('Alumno/top')


 <div class="col-sm-9" >
   <p> <h2>Tus cursos</h2></p>

            
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif

<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          <table class="table table-striped">
            <tr> 
              
              <th>Nombre</th>
              <th>Sala</th>
              <th>Hora</th>
               <th>Día</th>
              
            </tr>

            @foreach($datos_horario as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->dia}}</td>
            </tr>

             @endforeach

          </table>
          {!! $datos_horario->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop

	