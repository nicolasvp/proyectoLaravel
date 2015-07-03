@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM


@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Bienvenido Administrador </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">

                    <ul class="list-group" id="side-menu">
                    
                        
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>


        
             @include('Administrador/menu')
       
</li>
</ul>
</div>

</div>

   <div class="col-sm-9" >
   <p> <h2>Lista de Estudiantes : </h2></p><p>{{ $carrera->nombre }}</p>

            <p>
                         {!! Form::open(['action' => 'AdministradorController@get_createEstudiante', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar estudiante</button>

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
              <th>Rut</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Email</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_estudiantes as $estudiante)

            <tr>
               <td>{{ $estudiante->id}}</td>
               <td>{{ $estudiante->rut}}</td>
               <td>{{ $estudiante->nombres}}</td>
               <td>{{ $estudiante->apellidos}}</td>
               <td>{{ $estudiante->email}}</td>
              <td>
    
                  {!! Form::open(['action' => ['AdministradorController@get_editEstudiante'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $estudiante->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['AdministradorController@delete_destroyEstudiante'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $estudiante->id)!!}
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


@stop