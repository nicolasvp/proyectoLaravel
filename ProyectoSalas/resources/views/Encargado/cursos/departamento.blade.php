@extends('layouts/master')



@section('sideBar')


 @include('Encargado/top')
       



   <div class="col-sm-9" >
   <p> <h2>Seleccion de departamento</h2></p>

      @if(Session::has('message'))

           <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Encargado/messages')
       <div class="form-group">
  


 {!! Form::open(['action' => 'Encargado\CursoController@get_create', 'method' => 'GET']) !!}


    <div class="form-group">
   {!! Form::select('departamento', (['0' => '-- Seleccionar un departamento --']  +$departamentos), null, ['class' => 'form-control'])!!}
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