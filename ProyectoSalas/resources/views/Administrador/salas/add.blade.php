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
   <p> <h2>Selección de período y sala</h2></p>

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
   {!! Form::open(['action' => 'AdministradorController@post_add']) !!}

    <div class="form-group">
    {!! Form::hidden('curso_id', $curso_id)!!}
    </div>


    <div class="form-group">
    {!! Form::label('dia_id', 'Día') !!}
   {!! Form::select('dia_id', (['0' => 'Selecciona un día'] + $dias), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
    {!! Form::label('asig_periodo', 'Período') !!}
   {!! Form::select('asig_periodo', (['-1' => 'Selecciona un Período'] + $periodos), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
    {!! Form::label('asig_sala', 'Sala') !!}
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