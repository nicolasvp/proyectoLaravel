@extends('layouts/master')


@section('sideBar')



             
<div class="panel panel-default" style="margin-top: 40px;">
            @include('Administrador/menu')

         <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de Facultades</h2></p>



      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          {!! Form::open(['action' => ['Administrador\FacultadController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Campus']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


          {!! Form::open(['action' => 'Administrador\FacultadController@get_create', 'method' => 'GET']) !!}
   
           <button type="submit" class="btn btn-success">Ingresar</button>

         {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Campus</th>
              <th>Descripción</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_facultades as $facultad)

            <tr>
               <td>{{ $facultad->id}}</td>
               <td>{{ $facultad->nombre}}</td>
               <td>{{ $facultad->campus}}</td>
               <td>{{ $facultad->descripcion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\FacultadController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $facultad->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\FacultadController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $facultad->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar esta facultad?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_facultades->render() !!}
     
  </div>

                    
</div>
</div>
</div>
</div>
</div>
                    
</div>


      </div>



@stop