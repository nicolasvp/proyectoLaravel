@extends('layouts/master')

@section('welcome')

Gestión de salas - UTEM

@stop


@section('sideBar')



 @include('Encargado/menu');



   <div class="col-sm-9" >
   <p> <h2>Selección de día, período y sala</h2></p>

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
              <th>#</th>
              <th>Nombre</th>
              <th>Docente</th>
              <th>Sección</th>  
            </tr>

            @foreach($datos_curso as $cur)

            <tr>
               <td>{{ $cur->id}}</td>
               <td>{{ $cur->nombre}}</td>
               <td>{{ $cur->nombres}} {{$cur->apellidos}} - {{$cur->rut}}</td>
               <td>{{ $cur->seccion}}</td>
            </tr>
             @endforeach

          </table>
          {!! $datos_curso->render() !!}
    
 </div>
                    
</div>
</div>




<div class="panel panel-default">
    <div class="panel-body">
       <table class="table table-striped">

     <div class="form-group">
   {!! Form::open(['action' => 'EncargadoController@post_add']) !!}


<p> <h2>Selección de Día</h2></p>
    <div class="form-group">
   {!! Form::select('dia_id', (['0' => 'Selecciona un día'] + $dias), null, ['class' => 'form-control']) !!}
    </div>


<p> <h2>Selección de período</h2></p>



    <div class="form-group">
   {!! Form::select('asig_periodo', (['-1' => 'Selecciona un Período'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>



<p> <h2>Selección de sala</h2></p>
        <div class="form-group">
   {!! Form::select('asig_sala', (['0' => 'Selecciona una sala'] + $salas), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
    {!! Form::hidden('curso_id', $curso_id)!!}
    </div>

      <div align="center"<th><button type="submit" class="btn btn-primary ">Asignar</button></th></div>
      {!! Form::close() !!}


      </div>

      </table>

    </div>
</div>


</div>

                    
</div>


      </div>
    </div>

@stop