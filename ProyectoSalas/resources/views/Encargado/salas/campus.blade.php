@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

@include('Encargado/top')

  <div class="panel-body">                  
                  
   <div class="row">
   <div class="col-sm-9" >
   <p> <h2>Selección de Campus</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

         {!! Form::open(['action' => 'Encargado\SalaController@get_datos', 'method' => 'GET']) !!}

        <div class="form-group">
     {!! Form::select('campus', (['0' => '-- Selecciona un campus --'] + $campus), null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
    {!! Form::hidden('id_curso', $id_curso)!!}
    </div>

      <div align="center"<th><button type="submit" class="btn btn-primary ">Siguiente</button></th></div>
      {!! Form::close() !!}



  </div>
</div>




</div>

</div>
</div>

</div>
</div>
</div>

                    


                    
@stop