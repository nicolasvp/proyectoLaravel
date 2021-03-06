@extends('layouts/master')

@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
          @include('Administrador/menu')

         <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
         <p>
       {!! Form::open(['action' => 'Administrador\EscuelaController@get_download', 'method' => 'GET']) !!}
   
         <button type="submit" class="btn btn-info pull-right">Descargar archivo</button>

      {!! Form::close() !!}
    </p>

   <p> <h2>Lista de Escuelas</h2></p>

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          {!! Form::open(['action' => ['Administrador\EscuelaController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Departamento']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          {!! Form::open(['action' => 'Administrador\EscuelaController@get_create', 'method' => 'GET']) !!}
   
             <button type="submit" class="btn btn-success">Ingresar</button>

           {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Departamento</th>
              <th>Descripción</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_escuelas as $escuela)

            <tr>
               <td>{{ $escuela->id}}</td>
               <td>{{ $escuela->nombre}}</td>
               <td>{{ $escuela->departamento}}</td>
               <td>{{ $escuela->descripcion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\EscuelaController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $escuela->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\EscuelaController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $escuela->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar esta escuela?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_escuelas->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>

      </div>
    </div>
      </div>



@stop