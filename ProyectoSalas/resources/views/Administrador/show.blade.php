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
            <li><a href="">Asignar Perfil</a></li>               

       
</li>

</div>

</div>






<div class="col-sm-9" >
  <p> <h2>Perfiles de usuarios </h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">


{!! Form::open(['route' => 'Administrador.show', 'method' => 'GET', 'class' => 'navbar-form navbar-left pull-right', 'role' => 'search']) !!}
  <div class="form-group">
    {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingresa el rut']) !!}
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
{!! Form::close() !!}


       <div class="form-group">

        <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Rol_ID</th>
              <th>Acción</th>
            </tr>

            @foreach($usuarios as $users)

            <tr>
               <td>{{ $users->id}}</td>
               <td>{{ $users->rut}}</td>
               <td>{{ $users->rol_id}}</td>
               <td>
                  <a href="{{ route('Administrador.show', $users)}}">Editar</a>
               </td>
            </tr>
             @endforeach

          </table>

          {!! $usuarios->render() !!}

  </div>

  {!! Form::open(['route' => 'Administrador.store', 'method' => 'POST']) !!}

     <b>Usuario: "algo"</b>         Seleccione perfil {!! Form::select('size', array('L' => 'Large', 'S' => 'Small')) !!}

           <div align=center><button type="submit" class="btn btn-primary">Asignar nuevo perfil</button></div>


  {!! Form::close() !!}
                    
</div>

</div>


</div>

                    
</div>


      </div>
    </div>

@stop