@extends('layouts/master')


@section('sideBar')



           @include('Administrador/menu')
       

<div class="col-sm-9" >
  <p> <h2>Perfiles del usuario </h2></p>
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
              <th>Rol</th>
              <th>Acción</th>
              
            </tr>

            @foreach($datos_usuario as $users)
            
            <tr>
               <td>{{ $users->id}}</td>
               <td>{{ $users->rut}}</td>
               <td>{{ $users->nombre}}</td>
                <td> 
      {!! Form::open(['action' => ['Administrador\PerfilController@delete_destroy'], 'method' => 'DELETE']) !!}
      {!! Form::hidden('id', $users->id)!!}
       <button type="submit" onclick="return confirm('¿Seguro que desea eliminar?')" class="btn btn-danger btn-sm">Eliminar</button>
      {!! Form::close() !!}

               </td>
            </tr>
             @endforeach

          </table>
  

  </div>
                    
</div>
</div>
<p> <h2>Asignar perfil</h2></p>
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

      <div align="center"<th><button type="submit" onclick="return confirm('¿Seguro que desea asignar este perfil?')" class="btn btn-primary ">Asignar perfil</button></th></div>
      {!! Form::close() !!}

      </div>

      </table>

    </div>
</div>


</div>

                    
</div>


      </div>
    </div>

@stop