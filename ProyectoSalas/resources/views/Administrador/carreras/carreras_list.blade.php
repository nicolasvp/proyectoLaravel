@extends('layouts/master')

@section('sideBar')




      @include('Administrador/menu')
       



   <div class="col-sm-9" >
 
   <p> <h2>Lista de carreras</h2></p>

         <p>
                         {!! Form::open(['action' => 'AdministradorController@get_createCarrera', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar carrera</button>

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
              <th>Código</th>
              <th>Nombre</th>
              <th>Escuela</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_carreras as $carrera)

            <tr>
               <td>{{ $carrera->id}}</td>
               <td>{{$carrera->codigo}}</td>
               <td>{{ $carrera->nombre}}</td>
               <td>{{ $carrera->escuela}}</td>
      
              <td>
                  {!! Form::open(['action' => ['AdministradorController@get_editCarrera'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $carrera->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}
                
              </td>
              <td>
                  {!! Form::open(['action' => ['AdministradorController@delete_destroyCarrera'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $carrera->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar esta carrera?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_carreras->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop