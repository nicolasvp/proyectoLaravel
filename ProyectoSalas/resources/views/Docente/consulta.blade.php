@extends('layouts/master')



@section('welcome')

Gestión de salas - UTEM


@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i><b> Bienvenido Docente </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    
                        <li>
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Docente</a>
</li>
            <li> <a href="{{URL::to('/Docente/horario')}}">Horario</a></li>
            <li><a href="{{URL::to('/Docente/consulta')}}">Consultar</a></li>            

</li>

</div>

</div>


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
   {!! Form::open(['action' => 'DocenteController@get_resultado', 'method' => 'GET']) !!}

  
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