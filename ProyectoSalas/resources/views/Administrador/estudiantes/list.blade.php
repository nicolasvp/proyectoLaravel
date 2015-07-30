@extends('layouts/master')


@section('sideBar')


   
<div class="panel panel-default" style="margin-top: 40px;">     
             @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de Estudiantes</h2></p>

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

       {!! Form::open(['action' => ['Administrador\EstudianteController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Rut,Carrera']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

        {!! Form::open(['action' => 'Administrador\EstudianteController@get_create', 'method' => 'GET']) !!}
   
<<<<<<< HEAD
            <button type="submit" class="btn btn-success">Ingresar</button>
=======
            <button type="submit" class="btn btn-success">Ingresar estudiante</button>
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

        {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>Carrera</th>
              <th>Rut</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Email</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_estudiantes as $estudiante)

            <tr>
               <td>{{ $estudiante->carrera}}</td>
               <td>{{ $estudiante->rut}}</td>
               <td>{{ $estudiante->nombres}}</td>
               <td>{{ $estudiante->apellidos}}</td>
               <td>{{ $estudiante->email}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\EstudianteController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $estudiante->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\EstudianteController@delete_destroy'], 'method' => 'DELETE']) !!}
<<<<<<< HEAD
                  {!! Form::hidden('rut', $estudiante->rut)!!}
=======
                  {!! Form::hidden('id', $estudiante->id)!!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este estudiante?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_estudiantes->render() !!}
     
  </div>

                    
</div>
</div>
</div>
</div>
</div>
                    
</div>


      </div>


@stop