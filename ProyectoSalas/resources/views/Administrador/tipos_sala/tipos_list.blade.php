@extends('layouts/master')



@section('sideBar')


       
           @include('Administrador/menu')
       

   <div class="col-sm-9" >
   <p> <h2>Lista de Tipos de salas</h2></p>

            <p>
                         {!! Form::open(['action' => 'AdministradorController@get_createTipoSala', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar tipo</button>

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
              <th>Descripción</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_tipos as $tipo)

            <tr>
               <td>{{ $tipo->id}}</td>
               <td>{{ $tipo->nombre}}</td>
               <td>{{ $tipo->descripcion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['AdministradorController@get_editTipoSala'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $tipo->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['AdministradorController@delete_destroyTipoSala'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $tipo->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este tipo de sala?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_tipos->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop