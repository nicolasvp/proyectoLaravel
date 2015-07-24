@extends('layouts/master')

@section('sideBar')

           
<div class="panel panel-default" style="margin-top: 40px;">
           @include('Administrador/menu')


  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de horarios</h2></p>


      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif


<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          {!! Form::open(['action' => ['Administrador\SalaController@get_searchHorario'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
              
              <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Campus,Curso,Docente']) !!}
             
             </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          {!! Form::open(['action' => 'Administrador\SalaController@get_cursos', 'method' => 'GET']) !!}
   
            <button type="submit" class="btn btn-success">Ingresar horario</button>

          {!! Form::close() !!}




          <table class="table table-striped">
            <tr> 
              <th>Campus</th>
              <th>Curso</th>
              <th>Docente</th>
              <th>Período</th>
              <th>Sala</th>
              <th>Fecha</th>
              <th></th>
            </tr>

            
            @foreach($datos_horarios as $horario)

            <tr>
               <td>{{ $horario->campus}}</td>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->nombres}} {{$horario->apellidos}}</td>
               <td>{{ $horario->bloque}}
               <td>{{ $horario->sala}}</td>
               <td>{{ $horario->fecha}}</td>


     <td>
                 {!! Form::open(['action' => ['Administrador\SalaController@get_editHorario'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $horario->horario_id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

     </td>


      <td>

       {!! Form::open(['action' => ['Administrador\SalaController@delete_destroyHorario'], 'method' => 'DELETE']) !!}
        {!! Form::hidden('id', $horario->horario_id)!!}
        <button type="submit"  onclick="return confirm('¿Seguro que desea eliminar este horario?')" class="btn btn-danger btn-sm ">Eliminar</button>
        {!! Form::close() !!}

      </td>


            </tr>
             @endforeach

          </table>
          {!! $datos_horarios->render() !!}
     
  </div>

                    
</div>
</div>
</div>

   </div>
                 
</div>
</div>
</div>



@stop