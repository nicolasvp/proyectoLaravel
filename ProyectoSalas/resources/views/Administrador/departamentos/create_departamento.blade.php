@extends('layouts/master')



@section('sideBar')


             
             @include('Administrador/menu')


         <div class="col-sm-9" >
                     <p>
                         {!! Form::open(['action' => 'AdministradorController@get_facultadesDeptos', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>
         
   <p> <h2>Ingrese los datos para el departamento</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storeDepartamento'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('facultad_id', 'Facultad') !!}
       {!! Form::select('facultad_id', (['0' => '-- Seleccionar una facultad --'] +$facultades), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
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