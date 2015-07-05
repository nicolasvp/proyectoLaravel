@extends('layouts/master')



@section('sideBar')



@include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Lista de asignaturas</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
          {!! Form::open(['action' => ['EncargadoController@get_searchAsignatura'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Asignatura']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


</form>


          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Departamento</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th></th>
              <th></th>
            </tr>

            
            @foreach($datos_asignaturas as $asig)

            <tr>
               <td>{{ $asig->id }}</td>
               <td>{{ $asig->departamento}}
               <td>{{ $asig->codigo}}</td>
               <td>{{ $asig->nombre}}</td>
               <td>{{ $asig->descripcion}}</td>


          <td>
                 {!! Form::open(['action' => ['EncargadoController@get_asignaturas'], 'method' => 'GET']) !!}
          
                 <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                 {!! Form::close() !!}

          </td>


           <td>

               {!! Form::open(['action' => ['EncargadoController@get_asignaturas'], 'method' => 'GET']) !!}
          
                <button type="submit"  onclick="return confirm('¿Seguro que desea eliminar esta asignatura?')" class="btn btn-danger btn-sm ">Eliminar</button>
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