@extends('layouts.app')

@section('content')

  <section class="content-header">
      <h3>Generar Instalador</h3>
    <!-- Page header -->
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
    	<li><a href="{{ URL::to('katana/modulo') }}"> Modulo </a></li>
        <li class="active"> Crear archivo (zip) como instalador </li>
      </ul>
  </section>
  <div class="content"> 
  @if(Session::has('message'))    
       {{ Session::get('message') }}
  @endif  
  <div class="panel-default panel">
    <div class="panel-body">

    <ul class="parsley-error-list">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
     {!! Form::open(array('url'=>'katana/modulo/dopackage', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
          <div class="col-md-6">
              <div class="header" >
                <h3> Instant Module</h3>
              </div>
              
              <div class="content col-md-12" >
                <div class="form-group  " >
                  <label for="Module Id" class=" control-label  text-left"> Título de la Aplicacion </label>
                    {!! Form::text('app_name', '',array('class'=>'form-control', 'placeholder'=>'Ingresar titulo de la aplicacion', 'required'=>'true'   )) !!}
                </div>           
                  
                <div class="form-group  "  >
                  <label for="Module Id" class=" control-label  text-left"> SQL </label>
                  <div class="">
                    {!! Form::textarea('sql_cmd', '',array('class'=>'form-control', 'placeholder'=>'Copiar la instruccion desde alguna herramienta de administracion de Base de Datos y peguela aqui',  'rows' => 5 )) !!}
                   </div> 
                </div>           
			  
                <div class="form-group  " >
                  <label for="Module Id" class=" control-label  text-left"> Subir archivo SQL</label>
                  
                    {!! Form::file('sql_cmd_upload', '',array('class'=>'form-control', 'placeholder'=>'Ingrese la sentencia SQL',   )) !!}
                 
                </div>           
               	
                <div class="form-group  " >
                  <label for="library" class=" control-label  text-left"> Incluir archivo(s) de libreria</label>
                    @foreach( $file_inc['app/Library'] as $file )
                  <div class="" >
                   {!! Form::checkbox('file_library[]', $file ) !!}  <label>{!! $file !!} </label>
                  </div>
                    @endforeach
                </div>           
               	
                <div class="form-group  " >
                  <label for="lang" class=" control-label  text-left"> Incluir archivo(s) de Idioma</label>
                    @foreach( $file_inc['resources/lang/en'] as $file )
                  <div class="" >
                    {!! Form::checkbox('file_lang[]', $file ,array('class'=>'minimal_red')) !!} <label>{!! $file !!} </label>
                  </div>
                    @endforeach
                </div>           
               	
              
              </div>
              
          </div>
          
          
          <div class="col-md-6">
            <div class="header">
              <h3> Que es esto ?</h3>
            </div>
            
           <p> Zip Package es una herramienta para hacer una copia de seguridad de tu módulo como instalador . <br />
		   	Puede hacer una copia de seguridad del módulo actual e instalarlos en otra aplicación basada en estas librerias. </p>
		   </p> 
			<p> Todos los módulos comprimidos(zip) se almacenan en la carpeta <strong>uploads/zip</strong>. </p>
              
          </div>
      
      
      <div style="clear:both"></div>  
        
        <div class="form-group">
        <label class="col-sm-4 text-right">&nbsp;</label>
        <div class="col-sm-8">  
        <button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_save') }} </button>
        <button type="button" onclick="location.href='{{ URL::to('module') }}' " id="submit" class="btn btn-success ">  {{ Lang::get('core.sb_cancel') }} </button>
        </div>    
    
        </div> 
        
        {!! Form::hidden('enc_id'      , $enc_id )     !!}
        {!! Form::hidden('enc_module'  , $enc_module ) !!}
     
     {!! Form::close() !!}
    </div>
  </div>  
</div>   </div>      
   <script type="text/javascript">
  $(document).ready(function() { 
     
  });
  </script>     
 @endsection 