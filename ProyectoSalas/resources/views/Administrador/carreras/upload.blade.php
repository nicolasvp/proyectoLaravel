@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
@include('Administrador/menu')

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de ID de Escuelas</h2></p>

      @if(Session::has('message'))

        
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif



<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


 {!! Form::open(['action' => 'Administrador\CarreraController@post_upload','files'=>true]) !!}


        <table class="table table-striped">
            <tr> 
              <th>ID</th>
              <th>Escuela</th>
            </tr>

            @foreach($escuelas as $escuela)

            <tr>
               <td>{{ $escuela->id}}</td>
               <td>{{ $escuela->nombre}}</td>
            </tr>
             @endforeach

        </table>   
 {!! $escuelas->render() !!}   
 
<div class="form-group">
        <div class="panel-body">
          
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
              <label class="col-md-4 control-label">Seleccione el archivo con las carreras</label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
              </div>
            </div>
        </div>
 </div>

     <div align="center"<th><button type="submit" class="btn btn-success">Subir Carreras</button></th></div>

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