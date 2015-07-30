@extends('layouts/master')

@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
     
            @include('Administrador/menu')
       

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Selección de período y sala</h2></p>

      @if(Session::has('message'))

          
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')

       <div class="form-group">

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Docente</th>
              <th>Rut</th>
              <th>Sección</th>  
            </tr>

            @foreach($datos_curso as $cur)

            <tr>
               <td>{{ $cur->id}}</td>
               <td>{{ $cur->nombre}}</td>
               <td>{{ $cur->nombres}} {{$cur->apellidos}}</td>
               <td>{{$cur->rut}}</td>
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
       <table class="table table-striped">



     <div class="form-group">
   {!! Form::open(['action' => 'Administrador\SalaController@post_storeCurso']) !!}  


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
    <div class="form-group">
    {!! Form::hidden('curso', $curso_id)!!}
    </div>


    <div class="form-group">
    <p> <h2>Selección de período</h2></p>
   {!! Form::select('periodo', (['0' => 'Selecciona un Período'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
  <p> <h2>Selección de sala</h2></p>
   {!! Form::select('sala', (['0' => 'Selecciona una sala'] + $salas), null, ['class' => 'form-control']) !!}
    </div>

      <div align="center"<th><button type="submit" class="btn btn-primary ">Asignar</button></th></div>
      {!! Form::close() !!}


      </div>

      </table>

    </div>
</div>


</div>
</div>
                    
</div>


      </div>
    </div>

@stop