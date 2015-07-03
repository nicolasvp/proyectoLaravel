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
  <p> <h2>Editar los datos del periodo {{ $periodoEditable->bloque }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($periodoEditable, ['action' => ['AdministradorController@put_updatePeriodo', $periodoEditable], 'method' => 'PUT']) !!}

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