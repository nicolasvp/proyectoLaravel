@extends('layouts/master')



@section('sideBar')




     @include('Administrador/menu')
       

   <div class="col-sm-9" >
   <p> <h2>Lista de Asignaturas</h2></p>

            <p>
                         {!! Form::open(['action' => 'AdministradorController@get_createAsignatura', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar asignatura</button>

                         {!! Form::close() !!}
         </p>

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Código</th>
              <th>Departamento</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_asignaturas as $asignatura)

            <tr>
               <td>{{ $asignatura->id}}</td>
               <td>{{ $asignatura->nombre}}</td>
               <td>{{ $asignatura->codigo}}</td>
               <td>{{ $departamento->nombre}}</td>
              <td>
    
                  {!! Form::open(['action' => ['AdministradorController@get_editAsignatura'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $asignatura->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['AdministradorController@delete_destroyAsignatura'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $asignatura->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este curso?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_asignaturas->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop