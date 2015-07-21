@extends('layouts/master')

@section('sideBar')


         
             @include('Administrador/menu')
       

   <div class="col-sm-9" >
   <p> <h2>Lista de cursos</h2></p>

      @if(Session::has('message'))

        
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
          {!! Form::open(['action' => ['Administrador\SalaController@get_searchCurso'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Docente']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


</form>


          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Docente</th>
              <th>Sección</th>
              <th>Acción</th>
            </tr>

            @foreach($datos_cursos as $cur)

            <tr>
               <td>{{ $cur->id }}</td>
               <td>{{ $cur->nombre}}</td>
               <td>{{ $cur->nombres}} {{$cur->apellidos}} - {{$cur->rut}}</td>
               <td>{{ $cur->seccion}}</td>
               <td>

      {!! Form::open(['action' => ['Administrador\SalaController@post_curso'], 'method' => 'POST']) !!}
      {!! Form::hidden('id_curso', $cur->id)!!}
       <button type="submit" class="btn btn-success btn-sm">Seleccionar</button>
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


@stop