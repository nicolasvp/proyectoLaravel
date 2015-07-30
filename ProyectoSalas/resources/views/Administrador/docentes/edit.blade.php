@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
     @include('Administrador/menu')
       

  <div class="panel-body">                  
                  
   <div class="row">

<div class="col-sm-9" >
  <p> <h2>Editar los datos del docente: {{ $docenteEditable->nombres }} {{$docenteEditable->apellidos}}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

       @include('Administrador/messages')
       
       <div class="form-group">
  
      {!! Form::model($docenteEditable, ['action' => ['Administrador\DocenteController@put_update', $docenteEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('departamento', 'Departamento') !!}
<<<<<<< HEAD
       {!! Form::select('departamento', (['0' => '-- Seleccionar un Departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
=======
       {!! Form::select('departamento_id', (['0' => '-- Seleccionar un Departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
      </div>


      <div class="form-group">
       {!! Form::label('rut', 'Rut') !!}
<<<<<<< HEAD
       {!! Form::text('rut', $rut,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
=======
       {!! Form::text('rut', null,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
         
      </div>

      <div class="form-group">
        {!! Form::label('nombres', 'Nombres') !!}
       {!! Form::text('nombres', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombres']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos') !!}
       {!! Form::text('apellidos', null,['class' => 'form-control', 'placeholder' => 'Ingresa apellidos']) !!}
      </div>

<<<<<<< HEAD
      <div class="form-group">
        {!! Form::label('email', 'Email') !!}
       {!! Form::text('email', null,['class' => 'form-control', 'placeholder' => 'Ingresa email']) !!}
      </div>
      
=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
        {!! Form::hidden('id', $id)!!}
    

      <div align=center><button type="submit" class="btn btn-success">Actualizar</button></div>

      {!! Form::close() !!}

  
  </div>
<<<<<<< HEAD
      {!! Html::script('js/jquery-2.1.4.min.js') !!}
      <script src="http://localhost:8000/js/jquery.rut.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        $("#rut").rut();
       });
      </script> 
=======

>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
                    
</div>

</div>


</div>

                    
</div>
</div>

                    
</div>


      </div>


@stop