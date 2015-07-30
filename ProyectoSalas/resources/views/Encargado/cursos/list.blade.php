@extends('layouts/master')


@section('sideBar')




<div class="panel panel-default" style="margin-top: 40px;">
         
             @include('Encargado/top')
       
  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
 
   <p> <h2>Lista de Cursos</h2></p>


      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">


          {!! Form::open(['action' => ['Encargado\CursoController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
              <div class="form-group">
              {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Asignatura,Docente,Rut']) !!}
              </div>
              <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


          {!! Form::open(['action' => 'Encargado\CursoController@get_departamento', 'method' => 'GET']) !!}
   
              <button type="submit" class="btn btn-success">Ingresar</button>

          {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Asignatura</th>
              <th>Docente</th>
              <th>Rut</th>
              <th>Año</th>
              <th>Semestre</th>
              <th>Sección</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_cursos as $curso)

            <tr>
               <td>{{ $curso->id}}</td>
               <td>{{ $curso->nombre}}</td>
               <td>{{ $curso->nombres}} {{ $curso->apellidos}}</td>
               <td>{{ $curso->rut}}</td>
               <td>{{ $curso->anio}}</td>
               <td>{{ $curso->semestre}}</td>
               <td>{{ $curso->seccion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Encargado\CursoController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $curso->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Encargado\CursoController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $curso->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este curso?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_cursos->render() !!}
     
  </div>

                    
</div>
</div>
</div>
</div>
</div>
                    
</div>


      </div>



@stop