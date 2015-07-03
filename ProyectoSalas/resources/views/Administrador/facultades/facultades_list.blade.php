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
   <p> <h2>Lista de Facultades</h2></p>

            <p>
                         {!! Form::open(['action' => 'AdministradorController@get_createFacultad', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar facultad</button>

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
              <th>Campus</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_facultades as $facultad)

            <tr>
               <td>{{ $facultad->id}}</td>
               <td>{{ $facultad->nombre}}</td>
               <td>{{ $facultad->campus}}</td>
              <td>
    
                  {!! Form::open(['action' => ['AdministradorController@get_editFacultad'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $facultad->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['AdministradorController@delete_destroyFacultad'], 'method' => 'DELETE']) !!}
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


@stop