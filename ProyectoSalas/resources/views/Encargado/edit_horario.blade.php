@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM


@stop


@section('sideBar')



@include('Encargado/menu');



   <div class="col-sm-9" >
    @foreach($curso as $c)

   <p> <h2>Modificar horario de: {{$c->nombre}}</h2></p>
  
    @endforeach

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


   
      {!! Form::model($horarioEditable, ['action' => ['EncargadoController@put_updateHorario', $horarioEditable], 'method' => 'PUT']) !!}

    <div class="form-group">
    {!! Form::label('sala_id', 'Sala') !!}
   {!! Form::select('sala_id', (['0' => 'Selecciona una sala'] + $salas), null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('periodo_id', 'Período') !!}
   {!! Form::select('periodo_id', (['-1' => 'Selecciona un Período'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::hidden('curso_id', $curso_id)!!}

    <div class="form-group">
    {!! Form::label('dia_id', 'Día') !!}
   {!! Form::select('dia_id', (['0' => 'Selecciona un día'] + $dias), null, ['class' => 'form-control']) !!}
    </div>

    


    {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-info">Actualizar</button></div>

      {!! Form::close() !!}


</div>
</div>
</div>

                    
</div>


      </div>
    </div>


                    
@stop