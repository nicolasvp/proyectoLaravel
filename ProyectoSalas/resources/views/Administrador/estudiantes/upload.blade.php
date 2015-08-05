@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

@include('Administrador/menu')

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de ID de Carreras</h2></p>

      @if(Session::has('message'))

        
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif



<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


 {!! Form::open(['action' => 'Administrador\EstudianteController@post_upload','files'=>true]) !!}


           <table class="table table-striped">
            <tr> 
              <th>ID</th>
              <th>Carrera</th>
            </tr>

            @foreach($carreras as $carrera)

            <tr>
               <td>{{ $carrera->id}}</td>
               <td>{{ $carrera->nombre}}</td>
            </tr>
             @endforeach

        </table>   

  {!! $carreras->render() !!}
 
<div class="form-group">
        <div class="panel-body">
          
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
              <label class="col-md-4 control-label">Seleccione el archivo con los estudiantes</label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
              </div>
            </div>
        </div>
 </div>

     <div align="center"<th><button type="submit" class="btn btn-success">Subir Estudiantes</button></th></div>

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