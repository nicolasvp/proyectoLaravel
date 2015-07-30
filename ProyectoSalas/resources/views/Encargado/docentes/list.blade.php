@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
             
@include('Encargado/top')
       

  <div class="panel-body">                  
                  
   <div class="row">
    
   <div class="col-sm-9" >
   <p> <h2>Lista de Docentes</h2></p>

    

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          {!! Form::open(['action' => ['Encargado\DocenteController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Rut,Departamento']) !!}
            </div>
            <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          {!! Form::open(['action' => 'Encargado\DocenteController@get_create', 'method' => 'GET']) !!}
   
             <button type="submit" class="btn btn-success">Ingresar</button>

          {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Departamento</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_docentes as $docente)

            <tr>
               <td>{{ $docente->id}}</td>
               <td>{{ $docente->rut}}</td>
               <td>{{ $docente->nombres}}</td>
               <td>{{ $docente->apellidos}}</td>
               <td>{{ $docente->departamento}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Encargado\DocenteController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $docente->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Encargado\DocenteController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('rut', $docente->rut)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este docente?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_docentes->render() !!}
     
  </div>

                    
</div>
</div>
</div>

     </div>
</div>
               
</div>


      </div>


@stop