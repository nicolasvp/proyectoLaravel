@extends('layouts/master')



@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
@include('Encargado/top')

  <div class="panel-body">                  
                  
   <div class="row">


   <div class="col-sm-9" >
   <p> <h2>Lista de Asignaturas</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

        
          {!! Form::open(['action' => ['Encargado\AsignaturaController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Depto,Código']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          {!! Form::open(['action' => 'Encargado\AsignaturaController@get_create', 'method' => 'GET']) !!}
          
             <button type="submit" class="btn btn-success">Ingresar</button>

          {!! Form::close() !!}

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
                 {!! Form::open(['action' => ['Encargado\AsignaturaController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $asig->id)!!}
                 <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                 {!! Form::close() !!}

          </td>


           <td>

               {!! Form::open(['action' => ['Encargado\AsignaturaController@delete_destroy'], 'method' => 'DELETE']) !!}
                 {!! Form::hidden('id', $asig->id)!!}
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


      </div>


@stop