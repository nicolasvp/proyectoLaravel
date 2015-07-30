@extends('layouts/master')




@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">
             @include('Administrador/menu')
       

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de Usuarios del Sistema</h2></p>



      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

         {!! Form::open(['action' => ['Administrador\UsuarioController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Rut,Nombres,Apellidos,Email']) !!}
            </div>
            <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          {!! Form::open(['action' => 'Administrador\UsuarioController@get_create', 'method' => 'GET']) !!}
   
            <button type="submit" class="btn btn-success">Ingresar</button>

          {!! Form::close() !!}


          <table class="table table-striped">
            <tr> 
              <th>Rut</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Email</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_usuarios as $usuario)

            <tr>
               <td>{{ $usuario->rut}}</td>
               <td>{{ $usuario->nombres}}</td>
               <td>{{ $usuario->apellidos}}</td>
               <td>{{ $usuario->email}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\UsuarioController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('rut', $usuario->rut)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\UsuarioController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('rut', $usuario->rut)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este docente?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_usuarios->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>
      </div>



@stop