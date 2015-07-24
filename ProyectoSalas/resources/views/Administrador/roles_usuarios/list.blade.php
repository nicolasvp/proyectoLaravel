@extends('layouts/master')

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
            @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
 
   <p> <h2>Lista de roles</h2></p>

    
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

        {!! Form::open(['action' => ['Administrador\RolUsuarioController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Rut, Rol']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


        {!! Form::open(['action' => 'Administrador\RolUsuarioController@get_create', 'method' => 'GET']) !!}
       
          <button type="submit" class="btn btn-success">Asignar rol</button>

        {!! Form::close() !!}


          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Rol</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_roles as $rol)

            <tr>
               <td>{{ $rol->id}}</td>
               <td>{{ $rol->rut}}</td>
               <td>{{ $rol->nombre}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\RolUsuarioController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $rol->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\RolUsuarioController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $rol->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este rol?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_roles->render() !!}
     
  </div>

                    
</div>
</div>
</div>
</div>
                    
</div>


      </div>
    </div>


@stop