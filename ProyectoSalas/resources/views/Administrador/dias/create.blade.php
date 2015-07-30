@extends('layouts/master')

@section('sideBar')


  @include('Administrador/menu')
       

<div class="col-sm-9" >

                  <p>
                         {!! Form::open(['action' => 'Administrador\DiaController@get_upload', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
                       </p>

<p> <h2>Ingrese el nombre para el día</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\DiaController@post_store'], 'method' => 'POST']) !!}


      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>


      <div align=center><button type="submit" class="btn btn-info">Aceptar</button></div>

      {!! Form::close() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>

@stop