@extends('layouts/master')

@section('welcome')

Gestión de salas - UTEM

@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-edit" aria-hidden="true"></i><b> Bienvenido Encargado </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    
                        <li>
                       <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Encargado</a>
</li>

            <li> <a href="{{URL::to('/Encargado/cursos')}}">Asignar Salas</a></li>
            <li><a href="">Modificar Salas</a></li> 
            <li><a href="">Ingresar Datos</a></li>             

</li>

</div>

</div>


   <div class="col-sm-9" >
   <p> <h2>Selección de período y sala</h2></p>

      @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
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
       <table class="table table-striped">

<p> <h2>Selección de período</h2></p>

     <div class="form-group">
   {!! Form::open(['action' => 'EncargadoController@post_add']) !!}

    <div class="form-group">
    {!! Form::hidden('curso_id', $curso_id)!!}
    </div>

    <div class="form-group">
   {!! Form::select('asig_periodo', (['-1' => 'Selecciona un Período'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>

<p> <h2>Selección de sala</h2></p>
        <div class="form-group">
   {!! Form::select('asig_sala', (['0' => 'Selecciona una sala'] + $salas), null, ['class' => 'form-control']) !!}
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

@stop