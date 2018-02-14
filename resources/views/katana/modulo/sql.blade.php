@extends('layouts.app')

@section('content')

<div class="page-content row">
  <div class="page-content-wrapper m-t">
    <div class="sbox">
      <div class="sbox-title">
         <h1> {{ $pageTitle }} <small>Configuración</small></h1>
      </div>
      <div class="sbox-content">

          @include('katana.modulo.tab',array('active'=>'sql','type'=>  $type ))
  
          {!! Form::open(array('url'=>'katana/modulo/savesql/'.$modulo_nombre, 'class'=>'form-vertical ' ,'id'=>'SQL' , 'parsley-validate'=>'','novalidate'=>' ')) !!}
          <div class="infobox infobox-info fade in">
          <button type="button" class="close" data-dismiss="alert"> x </button>  
          <p> <strong>Tips !</strong> Puede utilizar un editor de consultas como <a href="http://code.google.com/p/sqlyog/downloads/list" target="_blank">SQL YOG </a> , PHP MyAdmin , para construir la consulta y obtener una vista previa de los resultados , <br /> luego copie y pegue la sentencia aqui </p>
          </div>  


          <div class="form-group">
          <label for="ipt" class=" control-label">SQL SELECT & JOIN</label>
          <textarea name="sql_select" rows="5" id="sql_select" class="tab_behave form-control"  placeholder="SQL Select & Join Statement" >{{ $sql_select }}</textarea>
          </div>  

          <div class="form-group">
          <label for="ipt" class=" control-label">SQL WHERE CONDITIONAL</label>
          <textarea name="sql_where" rows="2" id="sql_where" class="form-control" placeholder="SQL Where Statement" >{{ $sql_where }}</textarea>
          </div> 

          <div class="infobox infobox-danger fade in">
          <button type="button" class="close" data-dismiss="alert"> x </button>  
          <p> <strong>Advertencia !</strong> Por favor asegurese de que el SQL no esté vacio, para evitar problemas al momento  <strong>BUSCAR</strong> información   </p>
          </div>  
            


          <div class="form-group">
          <label for="ipt" class=" control-label">SQL GROUP</label>
          <textarea name="sql_group" rows="2" id="sql_group" class="form-control"   placeholder="SQL Grouping Statement" >{{ $sql_group }}</textarea>

          </div> 
          <div class="form-group">
          <label for="ipt" class=" control-label"></label>
          <button type="submit" class="btn btn-primary"> Guardar SQL </button>
          </div>  

          <input type="hidden" name="modulo_id" value="{{ $row->modulo_id }}" />
          <input type="hidden" name="modulo_nombre" value="{{ $row->modulo_nombre }}" />

          {!! Form::close() !!}


      </div>
    </div>
  </div>
</div>
 
<script type="text/javascript">
  $(document).ready(function(){

    <?php echo KatanaHelpers::sjForm('SQL'); ?>

  })
</script> 
@stop