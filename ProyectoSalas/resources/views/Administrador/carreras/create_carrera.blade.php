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
   <p> <h2>Ingrese los datos para la carrera</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storeCarrera'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('escuela_id', 'Escuela') !!}
       {!! Form::select('escuela_id', (['0' => '-- Seleccionar una escuela --'] +$escuelas), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('codigo', 'Código') !!}
       {!! Form::text('codigo', null,['class' => 'form-control', 'placeholder' => 'Ingresa código']) !!}   
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