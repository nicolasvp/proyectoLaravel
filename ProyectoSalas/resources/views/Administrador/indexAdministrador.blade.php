@extends('layouts/master')

@section('sideBar')



 @include('Administrador/menu')

   <div class="col-sm-9" >  

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>
       


      @endif


@stop