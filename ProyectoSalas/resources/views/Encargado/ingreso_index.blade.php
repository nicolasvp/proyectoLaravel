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
            <li><a href="{{URL::to('/Encargado/campus')}}">Modificar Salas</a></li> 
            <li><a href="{{URL::to('/Encargado/ingreso')}}">Ingresar Datos</a></li>             

</li>

</div>

</div>


   <div class="col-sm-9" >
   <p> <h2>Ingreso de datos académicos</h2></p>

      @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">



 {!! Form::open(['action' => 'EncargadoController@get_create', 'method' => 'GET']) !!}

    <div class="form-group">
    {!! Form::hidden('id', $id_c)!!}
    </div>

<div align="center"<th><button type="submit" class="btn btn-primary ">CURSOS</button></th></div>
  {!! Form::close() !!}




 {!! Form::open(['action' => 'EncargadoController@get_create', 'method' => 'GET']) !!}

    <div class="form-group">
    {!! Form::hidden('id', $id_a)!!}
    </div>

<div align="center"<th><button type="submit" class="btn btn-primary ">ASIGNATURA</button></th></div>
  {!! Form::close() !!}




   {!! Form::open(['action' => 'EncargadoController@get_create', 'method' => 'GET']) !!}

    <div class="form-group">
    {!! Form::hidden('id', $id_e)!!}
    </div>

<div align="center"<th><button type="submit" class="btn btn-primary ">ESTUDIANTE</button></th></div>
  {!! Form::close() !!}



   
  </div>
</div>









</div>



</div>
</div>
</div>

                    
</div>



<!--
 <script src="http://localhost:8000/js/jquery-1.11.3.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
                 $('.btn').click(function (){
                    alert("kjsdkajsdakj");
                 });
       });
      </script>

-->
                    
@stop