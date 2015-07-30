@extends('layouts/master')



@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">

@include('Encargado/top')

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de Horarios</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">

   <div class="panel-body">
       <div class="form-group">


          {!! Form::open(['action' => ['Encargado\HorarioController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Curso']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


          {!! Form::open(['action' => 'Encargado\SalaController@get_curso', 'method' => 'GET']) !!}
   
            <button type="submit" class="btn btn-success ">Asignar</button>

          {!! Form::close() !!}
                
</form>


          <table class="table table-striped">
            <tr> 
              <th>Campus</th>
              <th>Curso</th>
              <th>Período</th>
              <th>Hora</th>
              <th>Docente</th>
              <th>Sala</th>
              <th></th>
              <th></th>
            </tr>

            
            @foreach($datos_horarios as $horario)

            <tr>
               <td>{{ $horario->campus }}</td>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->bloque}}</td>
               <td>{{ $horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->nombres}} {{$horario->apellidos}}</td>
               <td>{{ $horario->sala}}</td> 
           <td>
                 {!! Form::open(['action' => ['Encargado\HorarioController@get_edit'], 'method' => 'GET']) !!}
                 {!! Form::hidden('id', $horario->horario_id)!!}
                 <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                 {!! Form::close() !!}

          </td>


           <td>

               {!! Form::open(['action' => ['Encargado\HorarioController@delete_destroy'], 'method' => 'DELETE']) !!}
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