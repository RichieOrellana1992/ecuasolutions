@extends('layouts.app')

@section('content')
<div class="page-content row">
  <div class="page-content-wrapper m-t">

<div class="sbox ">

      <div class="sbox-title">
         <h1> {{ $pageTitle }} <small>Configuración</small></h1>
      </div>
      <div class="sbox-content">

    @include('katana.modulo.tab',array('active'=>'subform'))

<ul class="nav nav-tabs" style="margin-bottom:10px;">
    <li  ><a href="{{ URL::to('katana/modulo/form/'.$modulo_nombre)}}">Configuración del Formulario </a></li>
    <li class="active" ><a href="{{ URL::to('katana/modulo/subform/'.$modulo_nombre)}}">Sub Formulario </a></li>
  <li ><a href="{{ URL::to('katana/modulo/formdesign/'.$modulo_nombre)}}">Diseño del Formulario</a></li>
</ul>    
  
    {!! Form::open(array('url'=>'katana/modulo/savesubform/'.$modulo_nombre, 'class'=>'form-horizontal  ','id'=>'fSubf')) !!}

        <input  type='text' name='master' id='master'  value='{{ $row->modulo_nombre }}'  style="display:none;" /> 
        <input  type='text' name='modulo_id' id='modulo_id'  value='{{ $row->modulo_id }}'  style="display:none;" />

         <div class="form-group">
          <label for="ipt" class=" control-label col-md-4"> Titulo del Sub Formulario <code>*</code></label>
          <div class="col-md-8">
            {!! Form::text('title', (isset($subform['title']) ? $subform['title']: null ),array('class'=>'form-control input-sm', 'placeholder'=>'' ,'required'=>'true')) !!} 
          </div> 
        </div>   

        <div class="form-group">
          <label for="ipt" class=" control-label col-md-4">Clave Maestra del Formulario <code>*</code></label>
        <div class="col-md-8">

              <select name="master_key" id="master_key" required="true" class="form-control input-sm"> 
              <?php foreach($fields as $field) {?>
                        <option value="<?php echo $field['field'];?>" <?php if(isset($subform['master_key']) && $subform['master_key'] == $field['field']) echo 'selected';?>><?php echo $field['field'];?></option>   
              <?php } ?>      
                    </select>   
         </div> 
        </div>  

        <div class="form-group">
          <label for="ipt" class=" control-label col-md-4"> Tomar <b>forma</b> desde el módulo </label>
        <div class="col-md-8">
              <select name="module" id="module" required="true" class="form-control input-sm">
              <option value="">-- Seleccionar Módulo --</option>
              <?php foreach($modulos as $module) {?>
                  <option value="<?php echo $module['modulo_nombre'];?>" <?php if(isset($subform['module']) && $subform['module'] == $module['modulo_nombre']) echo 'selected';?> ><?php echo $module['module_title'];?></option>
              <?php } ?>
                    </select>
         </div> 
        </div>  

         <div class="form-group">
          <label for="ipt" class=" control-label col-md-4">Sub Form Database <code>*</code></label>
        <div class="col-md-8">
          <select name="table" id="table" required="true" class="form-control input-sm">       
                    </select> 
         </div> 
        </div>       

         <div class="form-group">
          <label for="ipt" class=" control-label col-md-4">Sub Form Relation Key <code>*</code></label>
        <div class="col-md-8">
          <select name="key" id="key" required="true" class="form-control input-sm">
          </select> 
         </div> 
        </div>     

         <div class="form-group">
          <label for="ipt" class=" control-label col-md-4"></label>
        <div class="col-md-8">
          <button name="submit" type="submit" class="btn btn-primary"><i class="icon-bubble-check"></i> Guardar Maestro Detalle </button>
          @if(isset($subform['master_key']))
          <a href="{{ url('katana/modulo/subformremove/'.$modulo_nombre) }}" class="btn btn-danger"><i class="icon-cancel-circle2 "></i> Remove </a>
          @endif
         </div> 
        </div> 
      
     {!! Form::close() !!}
    </div>
  </div>
</div>    
</div>
 <script>
$(document).ready(function(){   
    $("#table").jCombo("{{ url('katana/modulo/combotable') }}",
    {selected_value : "{{ (isset($subform['table']) ? $subform['table']: null ) }}" }); 
    $("#key").jCombo("{{ url('katana/modulo/combotablefield') }}?table=",
    { parent  :  "#table" , selected_value : "{{ (isset($subform['key']) ? $subform['key']: null ) }}"}); 
});
</script> 

<script type="text/javascript">
  $(document).ready(function(){

    <?php echo KatanaHelpers::sjForm('fSubf'); ?>

  })
</script>

@stop     