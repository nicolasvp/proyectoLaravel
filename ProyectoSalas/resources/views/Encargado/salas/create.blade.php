@extends('layouts/master')


@section('sideBar')



 @include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Selección de día, período y sala</h2></p>

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
              <th>Asignatura</th>
              <th>Docente</th>
              <th>Sección</th>  
            </tr>

            @foreach($datos_curso as $cur)

            <tr>
               <td>{{ $cur->id}}</td>
               <td>{{ $cur->nombre}}</td>
               <td>{{ $cur->nombres}} {{$cur->apellidos}} - {{$cur->rut}}</td>
               <td>{{ $cur->seccion}}</td>
            </tr>
             @endforeach

          </table>
          {!! $datos_curso->render() !!}
    
 </div>
                    
</div>
</div>


<div class="panel panel-default">
    <div class="panel-body">

       @include('Encargado/messages')


     <div class="form-group">
   {!! Form::open(['action' => 'Encargado\SalaController@post_store']) !!}



<table class="table table-striped">
<tr>
<td><p>Fecha de inicio</p></td>
<td>{!! Form::date('inicio', \Carbon\Carbon::now()) !!}</td>
<td><p>Fecha de término</p></td>
<td>{!! Form::date('termino', \Carbon\Carbon::now()) !!}</td>
</tr>

 </table>

<p> <h2>Selección de dias</h2></p>
          <table class="table table-striped">
            <tr> 
              <th>   <div class="form-group">Lunes  {!! Form::checkbox('lunes', '1' ) !!}</div></th>
              <th><div class="form-group">Martes  {!! Form::checkbox('martes', '2' ) !!}</div></th>
              <th>     <div class="form-group">Miércoles  {!! Form::checkbox('miercoles', '3' ) !!}</div></th>
              <th><div class="form-group">Jueves  {!! Form::checkbox('jueves', '4' ) !!}</div></th>
              <th>   <div class="form-group">Viernes  {!! Form::checkbox('viernes', '5' ) !!}</div></th>
               <th>   <div class="form-group">Sábado  {!! Form::checkbox('sabado', '6' ) !!}</div></th>
            </tr>
     

          </table>

<p> <h2>Selección de período</h2></p>

    <div class="form-group">
   {!! Form::select('periodo', (['0' => '-- Selecciona un Período --'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>


<p> <h2>Selección de sala</h2></p>
        <div class="form-group">
   {!! Form::select('sala', (['0' => '-- Selecciona una sala --'] + $salas), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
    {!! Form::hidden('curso', $curso_id)!!}
    </div>

 

      <div align="center"<th><button type="submit" class="btn btn-primary ">Asignar</button></th></div>
      {!! Form::close() !!}


      </div>

      

    </div>
</div>


</div>

                    
</div>


      </div>
    </div>

@stop