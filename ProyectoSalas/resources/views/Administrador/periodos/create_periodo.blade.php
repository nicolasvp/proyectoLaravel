@extends('layouts/master')


@section('sideBar')



         
            @include('Administrador/menu')
       

         <div class="col-sm-9" >
                            <p>
                         {!! Form::open(['action' => 'AdministradorController@get_uploadPeriodos', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>

   <p> <h2>Ingrese los datos para el período</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storePeriodo'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('bloque', 'Bloque') !!}
       {!! Form::text('bloque', null,['class' => 'form-control', 'placeholder' => 'Ingresa bloque']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('inicio', 'Inicio') !!}
       {!! Form::text('inicio', null,['class' => 'form-control', 'placeholder' => 'Ingresa hora inicio']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('fin', 'Fin') !!}
       {!! Form::text('fin', null,['class' => 'form-control', 'placeholder' => 'Ingresa hora fin']) !!}
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