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
                    <ul class="list-group" id="side-menu">
                    
                        
                       <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Encargado</a>

            <li class="list-group-item"> <a href="{{URL::to('/Encargado/cursos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignar Salas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Encargado/campus')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Modificar Salas</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/Encargado/ingreso')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Ingresar Datos</a></li>             

</li>
</ul>
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


          <table class="table table-striped table-hover ">
  <thead>
    <tr>
      
      <th> </th>
      <th> </th>
    
    </tr>
  </thead>
  <tbody>
    <tr>
    
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Curso</b></h3></td>
      <td>             
                     {!! Form::open(['action' => 'EncargadoController@get_departamento', 'method' => 'GET']) !!}

                      <div class="form-group">
                      {!! Form::hidden('id', $id_c)!!}
                      </div>

                  <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                    {!! Form::close() !!}

      </td>
     
    </tr>
    <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Asignatura</b></h3></td>
      <td>                     {!! Form::open(['action' => 'EncargadoController@get_create', 'method' => 'GET']) !!}

                        <div class="form-group">
                        {!! Form::hidden('id', $id_a)!!}
                        </div>

                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
          
      </td>
      
    </tr>
    <tr>
     
      <td> <h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Estudiante </b></h3></td>
      <td>         
                       {!! Form::open(['action' => 'EncargadoController@get_escuela', 'method' => 'GET']) !!}

                        <div class="form-group">
                        {!! Form::hidden('id', $id_e)!!}
                        </div>

                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
      </td>

  </tbody>
</table> 






      


   
                     


           
           
                  

   
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