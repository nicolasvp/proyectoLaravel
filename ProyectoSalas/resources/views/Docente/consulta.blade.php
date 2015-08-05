@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/docente">Gestión de Salas UTEM</a>
@stop

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px">

@include('Docente/menu')


<div class="col-sm-9">

   <p> <h2>Consultar asignaciones de salas</h2></p>

            
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif

<div class="panel panel-default" style="margin-top: 15px">
<div class="panel-body">

  @include('Docente/messages')

  <div class="form-group">

              <table class="table table-striped">


               <div class="form-group">
             {!! Form::open(['action' => 'Docente\DocenteController@get_resultado', 'method' => 'GET']) !!}

              <div class="form-group">
              {!! Form::label('dia','Día') !!}
              {!! Form::date('dia', \Carbon\Carbon::now()) !!}
            </div>
            
              <div class="form-group">
                {!! Form::label('campus', 'Campus') !!}
             {!! Form::select('campus', (['0' => 'Selecciona un Campus'] + $campus), null, ['class' => 'form-control']) !!}
              </div>

             
               <div class="form-group">
                {!! Form::label('periodo', 'Período') !!}
             {!! Form::select('periodo', (['0' => 'Selecciona un Periodo'] + $periodo), null, ['class' => 'form-control']) !!}
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
      

@stop