@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM


@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Bienvenido Administrador </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">

                    <ul class="list-group" id="side-menu">
                    
                        
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>


            @include('Administrador/menu') 
       
</li>
</ul>
</div>

</div>






<div class="col-sm-9" >
  <p> <h2>Editar los datos del curso: {{ $cursoEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($cursoEditable, ['action' => ['AdministradorController@put_updateCurso', $cursoEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('asignatura_id', 'Asignatura') !!}
       {!! Form::select('asignatura_id', (['0' => '-- Seleccionar una asignatura --'] +$asignaturas), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
        {!! Form::label('docente_id', 'Docente') !!}
       {!! Form::select('docente_id', (['0' => '-- Seleccionar un docente --'] +  $docentes), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('semestre', 'Semestre') !!}
       {!! Form::text('semestre', null,['class' => 'form-control', 'placeholder' => 'Ingresa semestre']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('año', 'Año') !!}
       {!! Form::text('anio', null,['class' => 'form-control', 'placeholder' => 'Ingresa año']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('seccion', 'Sección') !!}
       {!! Form::text('seccion', null,['class' => 'form-control', 'placeholder' => 'Ingresa sección']) !!}
      </div>

        {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-info">Actualizar</button></div>

      {!! Form::close() !!}

  
  </div>

                    
</div>

</div>


</div>

                    
</div>


      </div>
    </div>

@stop