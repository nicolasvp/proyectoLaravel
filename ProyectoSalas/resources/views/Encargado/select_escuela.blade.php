@extends('layouts/master')




@section('sideBar')



@include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Selección de Escuela</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


 {!! Form::open(['action' => 'EncargadoController@get_create', 'method' => 'GET']) !!}


    <div class="form-group">
   {!! Form::select('escuela', ( $escuela), null, ['class' => 'form-control'])!!}
    </div>

      <div class="form-group">
    {!! Form::hidden('id', $id)!!}
    </div>


     <div align="center"<th><button type="submit" class="btn btn-primary">Siguiente</button></th></div>


    {!! Form::close() !!}


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