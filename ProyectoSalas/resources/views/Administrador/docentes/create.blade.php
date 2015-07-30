@extends('layouts/master')



@section('sideBar')

 <div class="panel panel-default" style="margin-top: 40px;">     
            @include('Administrador/menu')
       


  <div class="panel-body">                  
                  
   <div class="row">

         <div class="col-sm-9" >

                  <p>
                         {!! Form::open(['action' => 'Administrador\DocenteController@get_deptos', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
                       </p>


   <p> <h2>Ingrese los datos para el docente</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

       @include('Administrador/messages')
    
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\DocenteController@post_store'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('departamento_id', 'Departamento') !!}
       {!! Form::select('departamento', (['0' => '-- Seleccionar un departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('rut', 'Rut') !!}
       {!! Form::text('rut', null,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('nombres', 'Nombres') !!}
       {!! Form::text('nombres', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombres']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos') !!}
       {!! Form::text('apellidos', null,['class' => 'form-control', 'placeholder' => 'Ingresa apellidos']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('email', 'Email') !!}
       {!! Form::text('email', null,['class' => 'form-control', 'placeholder' => 'Ingresa email']) !!}
      </div>


      <div align=center><button type="submit" class="btn btn-info">Aceptar</button></div>

      {!! Form::close() !!}
     
  </div>

  
      {!! Html::script('js/jquery-2.1.4.min.js') !!}
      <script src="http://localhost:8000/js/jquery.rut.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        $("#rut").rut();
       });
      </script> 
                    
</div>
</div>
</div>
</div>
</div>

                    
</div>


      </div>
  

@stop