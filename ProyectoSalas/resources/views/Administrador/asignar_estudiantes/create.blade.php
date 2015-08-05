@extends('layouts/master')



@section('sideBar')


    
<div class="panel panel-default" style="margin-top: 40px;">  
             @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">
         <div class="col-sm-9" >
              <p>
                         {!! Form::open(['action' => 'Administrador\AsignaturaCursadaController@get_upload', 'method' => 'GET']) !!}
   
                           {!! Form::hidden('id', $curso_id)!!}
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
              </p>

   <p> <h2>Ingrese el rut del estudiante</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')

    @if(Session::has('message'))

        <div class="alert alert-dismissible alert-success">
          <strong>{{ Session::get('message') }}</strong>
        </div>
       
    @endif
    
    {!! Form::open(['action' =>  ['Administrador\AsignaturaCursadaController@post_store'], 'method' => 'POST', 'class' => 'navbar-form navbar-left']) !!}
      <div class="form-group">
        {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingresa el rut']) !!}
      </div>
        {!! Form::hidden('id', $curso_id)!!}
      <button type="submit" class="btn btn-default">Ingresar</button>
    {!! Form::close() !!}


      {!! Html::script('js/jquery-2.1.4.min.js') !!}
      <script src="http://localhost:8000/js/jquery.rut.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        $("#rut").rut();
       });
      </script> 

                    
</div>
</div>
</div>

  </div>
                  
</div>


      </div>
    </div>

@stop