@extends('layouts/master')




@section('sideBar')



@include('Encargado/top')


   <div class="col-sm-9" >
   <p> <h2>Ingreso de datos académicos</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

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