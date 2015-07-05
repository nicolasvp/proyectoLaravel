@extends('layouts/master')



@section('sideBar')

@include('Alumno/top')



 <div class="col-sm-9">
   <p>                                                    
                        </p>
                        <div class="bs-docs-section">                
<div class="panel panel-default">
   <div class="panel heading"><h2> Consultar asignaciones de salas</h2></div>
<div class="panel-body">
 
  <div class="form-group">
    
    <table class="table table-striped">


     <div class="form-group">
   {!! Form::open(['action' => 'AlumnoController@get_resultado', 'method' => 'GET']) !!}

  
    <div class="form-group">
      {!! Form::label('campus', 'Campus') !!}
   {!! Form::select('campus', (['0' => 'Selecciona un Campus'] + $campus), null, ['class' => 'form-control']) !!}
    </div>

   
     <div class="form-group">
      {!! Form::label('periodo', 'Período') !!}
   {!! Form::select('periodo', (['0' => 'Selecciona un Periodo'] + $periodo), null, ['class' => 'form-control']) !!}
    </div>

    
     <div class="form-group">
      {!! Form::label('dia', 'Día') !!}
   {!! Form::select('dia', (['0' => 'Selecciona un Día'] + $dia), null, ['class' => 'form-control']) !!}
    </div>

      <div align="center"<th><button type="submit"  class="btn btn-primary ">Consultar</button></th></div>
      {!! Form::close() !!}

      </div>

      </table>

   


   
 
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>

@stop