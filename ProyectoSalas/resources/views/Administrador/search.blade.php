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
                    <ul class="nav" id="side-menu">
                    
                        <li>
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>
</li>
            <li> <a href="{{ route('Administrador.create') }}">Crear Campus</a></li>
            <li><a href="{{ route('Administrador.index') }}">Modificar Campus</a></li>
            <li><a href="">Archivar Campus</a></li>
            <li><a href="{{URL::to('/Administrador/search')}}">Asignar Perfil</a></li>               

       
</li>

</div>

</div>






<div class="col-sm-9" >
  <p> <h2>Buscar usuario </h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">


{!! Form::open(['route' => 'Administrador.show', 'method' => 'GET', 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
  <div class="form-group">
    {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingresa el rut']) !!}
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
{!! Form::close() !!}


      
</div>

</div>


</div>

                    
</div>


      </div>
    </div>

@stop