@extends('layouts/master')


@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

           @include('Administrador/menu')
       
   <div class="panel-body">                  
                  
   <div class="row">

<div class="col-sm-9" >
  @foreach($datos_usuario as $usuario)
  <p> <h2>Perfiles del Usuario: {{ $usuario->nombres}} {{ $usuario->apellidos}}</h2></p>
  @endforeach
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">


      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>
       


      @endif
       <div class="form-group">

        <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Acción</th>
              
            </tr>

            @foreach($roles_usuario as $rol)
            
            <tr>
               <td>{{ $rol->id}}</td>
               <td>{{ $rol->rut}}</td>
               <td>{{ $rol->nombres}} {{ $rol->apellidos }}</td>
               <td>{{ $rol->email }}</td>
               <td>{{ $rol->rol}}</td>
                <td> 
      {!! Form::open(['action' => ['Administrador\PerfilController@delete_destroy'], 'method' => 'DELETE']) !!}
<<<<<<< HEAD
      {!! Form::hidden('id', $rol->id)!!}
=======
      {!! Form::hidden('id', $users->id)!!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
       <button type="submit" onclick="return confirm('¿Seguro que desea eliminar?')" class="btn btn-danger btn-sm">Eliminar</button>
      {!! Form::close() !!}

               </td>
            </tr>
             @endforeach

          </table>
  

  </div>
                    
</div>
</div>
<p> <h2>Asignar Perfil</h2></p>
<div class="panel panel-default">
    <div class="panel-body">

       <table class="table table-striped">


     <div class="form-group">
   {!! Form::open(['action' => 'Administrador\PerfilController@post_profile']) !!}

    <div class="form-group">
    {!! Form::hidden('rut', $rut)!!}
    </div>

    <div class="form-group">
   {!! Form::select('rol_asig', (['0' => 'Selecciona un Perfil'] + $rol_usuario), null, ['class' => 'form-control']) !!}
    </div>

<<<<<<< HEAD
      <div align="center"<th><button type="submit"  class="btn btn-success">Aceptar</button></th></div>
=======
      <div align="center"<th><button type="submit" onclick="return confirm('¿Seguro que desea asignar este perfil?')" class="btn btn-success">Asignar perfil</button></th></div>
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
      {!! Form::close() !!}

      </div>

      </table>

    </div>
</div>


</div>

                    
</div>

  </div>
      </div>
    </div>

@stop