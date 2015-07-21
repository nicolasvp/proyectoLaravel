@extends('layouts/master')




@section('sideBar')


            @include('Administrador/menu')
       

   <div class="col-sm-9" >
 
   <p> <h2>Lista de los departamentos</h2></p>


      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          {!! Form::open(['action' => ['Administrador\DepartamentoController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Departamento,Facultad']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


            {!! Form::open(['action' => 'Administrador\DepartamentoController@get_create', 'method' => 'GET']) !!}
   
           <button type="submit" class="btn btn-success">Ingresar departamento</button>

           {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Facultad</th>
              <th>Descripcion</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_departamentos as $departamento)

            <tr>
               <td>{{ $departamento->id}}</td>
               <td>{{ $departamento->nombre}}</td>
               <td>{{ $departamento->facultad}}</td>
               <td>{{ $departamento->descripcion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\DepartamentoController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $departamento->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\DepartamentoController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $departamento->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este departamento?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_departamentos->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop