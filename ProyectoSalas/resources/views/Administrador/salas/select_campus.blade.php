@extends('layouts/master')

@section('sideBar')



        @include('Administrador/menu')
       


   <div class="col-sm-9" >
   <p> <h2>Selecciona campus</h2></p>

      @if(Session::has('message'))

          
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


 {!! Form::open(['action' => 'Administrador\SalaController@get_salas', 'method' => 'GET']) !!}


    <div class="form-group">
   {!! Form::select('select_campus', ( $salas_campus), null, ['class' => 'form-control'])!!}
    </div>

     <div align="center"<th><button type="submit" class="btn btn-primary">Siguiente</button></th></div>


    {!! Form::close() !!}


</div>
</div>
</div>

                    
</div>


      </div>
    </div>

                    
@stop