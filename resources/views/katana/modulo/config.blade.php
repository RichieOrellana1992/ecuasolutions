@extends('layouts.app')

@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">

		<div class="sbox">
			<div class="sbox-title">
				 <h1> {{ $pageTitle }} <small>Configuración</small></h1>
			</div>
			<div class="sbox-content clearfix">

			@include('katana.modulo.tab',array('active'=>'config','type'=> $type))

	<div class="col-md-6">
	{!! Form::open(array('url'=>'katana/modulo/saveconfig/'.$modulo_nombre, 'class'=>'form-horizontal ','id'=>'configA' , 'parsley-validate'=>'','novalidate'=>' ')) !!}
	<input  type='hidden' name='modulo_id' id='modulo_id'  value='{{ $row->modulo_id }}'   />
  	<fieldset>
		<legend> Información del Módulo </legend>
  		<div class="form-group">
    		<label for="ipt" class=" control-label col-md-4">Nombre / Titulo </label>
			<div class="col-md-8">
				<div class="input-group input-group-sm" style="margin:1px 0 !important;">
				<input  type='text' name='modulo_titulo' id='modulo_titulo' class="form-control " required="true" value='{{ $row->modulo_titulo }}'  />
				<span class="input-group-addon xlick bg-default btn-sm " >ES  </span>
			</div> 		
			@if($config->lang =='true')
			  <?php $lang = SiteHelpers::langOption();
			   if($ktnconfig['cnf_multilang'] ==1) {
				foreach($lang as $l) { if($l['folder'] !='es') {
			   ?>
			   <div class="input-group input-group-sm" style="margin:1px 0 !important;">
				 <input name="language_title[<?php echo $l['folder'];?>]" type="text"   class="form-control" placeholder="Etiqueta en <?php echo $l['name'];?>"
				 value="<?php echo (isset($modulo_lang['title'][$l['folder']]) ? $modulo_lang['title'][$l['folder']] : '');?>" />
				<span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
			   </div> 
	 		
 			 <?php } } }?>	  
 			  @endif
			 </div> 
			
  		</div>   

		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4">Nota del Módulo</label>
			<div class="col-md-8">
				<div class="input-group input-group-sm" style="margin:1px 0 !important;">
				<input  type='text' name='modulo_nota' id='modulo_nota'  value='{{ $row->modulo_nota }}' class="form-control input-sm "  />
				<span class="input-group-addon xlick bg-default btn-sm " >ES</span>
			</div> 
			@if($config->lang =='true')	
		  <?php $lang = SiteHelpers::langOption();
		   if($ktnconfig['cnf_multilang'] ==1) {
			foreach($lang as $l) { if($l['folder'] !='es') {
		   ?>
		   <div class="input-group input-group-sm" style="margin:1px 0 !important;">
			 <input name="language_note[<?php echo $l['folder'];?>]" type="text"   class="form-control input-sm" placeholder="Nota en <?php echo $l['name'];?>"
			 value="<?php echo (isset($modulo_lang['note'][$l['folder']]) ? $modulo_lang['note'][$l['folder']] : '');?>" />
			<span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
		   </div> 
			 
		  <?php } } }?>	
		  	 @endif	

			 </div> 
		 </div>   
		
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Controlador </label>
		<div class="col-md-8">
		<input  type='text' name='modulo_nombre' id='modulo_nombre' readonly="1"  class="form-control input-sm" required value='{{ $row->modulo_nombre }}'  />
		 </div> 
	  </div>  
  
	   <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Tabla BD</label>
		<div class="col-md-8">
		<input  type='text' name='modulo_db' id='modulo_db' readonly="1"  class="form-control input-sm" required value='{{ $row->modulo_db}}'  />
		  
		 </div> 
	  </div>  
  
	  <div class="form-group" style="display:none;" >
		<label for="ipt" class=" control-label col-md-4">Autor </label>
		<div class="col-md-8">
		<input  type='text' name='modulo_autor' id='modulo_autor' class="form-control input-sm"  readonly="1"  value='{{ $row->modulo_autor }}'  />
		 </div> 
	  </div>  

		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> ShortCode </label>
			<div class="col-md-8 " >
				
						<b>Form Shortcode : </b><code><br /><?php echo "[sc:Sximo fnc=showForm|id=".$row->modulo_nombre."] [/sc]"; ?></code><br />
					<b>Table Shortcode : </b><br />
					<code><?php echo "[sc:Sximo fnc=render|id=".$row->modulo_nombre."] [/sc]"; ?></code>
			</div> 
		</div>  	  
	 
		<div class="form-group">
			<label for="ipt" class=" control-label col-md-4"></label>
			<div class="col-md-8">
			<button type="submit" name="submit" class="btn btn-primary"> Actualizar Módulo </button>
			 </div> 
		</div>   

	</fieldset>
  	{!! Form::close() !!}
	
  
	</div>


	 @if($config->advance =='true') 
 <div class="col-sm-6 col-md-6"> 

 @if($type !='report' && $type !='generic')
  {!! Form::open(array('url'=>'katana/modulo/savesetting/'.$modulo_nombre, 'class'=>'form-horizontal ' ,'id'=>'configB')) !!}
  <input  type='text' name='module_id' id='module_id'  value='{{ $row->modulo_id }}'  style="display:none; " />
  	<fieldset>
		<legend> Configuración del Módulo </legend>

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Tipo de Cuadricula </label>
			<div class="col-md-8">			

				<select class="form-control input-sm" name="module_type">
					<?php if($row->modulo_type  =='addon') $row->modulo_type ='native'; ?>
					@foreach($cruds as $crud)
						<option value="{{ $crud->type }}" 
						@if($crud->type == $row->modulo_type ) selected @endif
						>{{ $crud->name }} </option>
					@endforeach
				</select>	
				
			 </div> 
		  </div> 


	
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Orden por defecto  </label>
		<div class="col-md-8">
			<select class="select-alt" name="orderby">
			@foreach($tables as $t)
				<option value="{{ $t['field'] }}"
				@if($setting['orderby'] ==$t['field']) selected="selected" @endif 
				>{{ $t['label'] }}</option>
			@endforeach
			</select>
			<select class="select-alt" name="ordertype">
				<option value="asc" @if($setting['ordertype'] =='asc') selected="selected" @endif > Ascending </option>
				<option value="desc" @if($setting['ordertype'] =='desc') selected="selected" @endif > Descending </option>
			</select>
			
		 </div> 
	  </div> 
	  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Mostrar filas </label>
		<div class="col-md-8">
			<select class="select-alt" name="perpage">
				<?php $pages = array('10','20','30','50');
				foreach($pages as $page) {
				?>
				<option value="<?php echo $page;?>"  @if($setting['perpage'] ==$page) selected="selected" @endif > <?php echo $page;?> </option>
				<?php } ?>
			</select>	
			/ Pagina
		 </div> 
	  </div>   
		
	</fieldset>	
	 @if($config->setting->method =='true') 
  	<fieldset>
	<legend> Form & View Setting </legend>
		<p> <i>You can switch this setting and applied to current module without have to rebuild </i></p>

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Form Method </label>
			<div class="col-md-8">
				<label class="radio-inline">
				<input type="radio" value="native" name="form-method" class="minimal-red" 
				 @if($setting['form-method'] == 'native') checked="checked" @endif 
				 /> New Page  
				</label>
				<label class="radio-inline">
				<input type="radio" value="modal" name="form-method"  class="minimal-red" 
				 @if($setting['form-method'] == 'modal') checked="checked" @endif 			
				/> Modal  
				</label>							
			 </div> 
		  </div> 

		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> View  Method </label>
			<div class="col-md-8">
				<label class="radio-inline">
				<input type="radio" value="native" name="view-method" class="minimal-red" 
				 @if($setting['view-method'] == 'native') checked="checked" @endif 
				 /> New Page  
				</label>
				<label class="radio-inline">
				<input type="radio" value="modal" name="view-method" class="minimal-red"  
				 @if($setting['view-method'] == 'modal') checked="checked" @endif 			
				/> Modal  
				</label>	
				<label class="radio-inline">
				<input type="radio" value="expand" name="view-method" class="minimal-red"  
				 @if($setting['view-method'] == 'expand') checked="checked" @endif 			
				/> Expand Grid   
				</label>

			 </div> 
		  </div> 		  

		  <div class="form-group" >
			<label for="ipt" class=" control-label col-md-4"> Inline add / edit row </label>
			<div class="col-md-8">
				<label class="checkbox-inline">
				<input type="checkbox" value="true" name="inline" class="minimal-red" 
				@if($setting['inline'] == 'true') checked="checked" @endif 	
				 /> Yes  Allowed 
				</label>
										
			 </div> 
		  </div> 		  

		  
		   <p class="alert alert-warning"> <strong> Important ! </strong> this setting only work with module where have <strong>Adavance </strong> Option</p>
	</fieldset>


	@endif

			  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"></label>
			<div class="col-md-8">
			<button type="submit" name="submit" class="btn btn-primary"> Actualizar Configuración </button>
			 </div> 
		  </div> 

	{!! Form::close() !!}
	@endif
	
  </div>
  	@endif

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){

		<?php echo KatanaHelpers::sjForm('configA'); ?>
		<?php echo KatanaHelpers::sjForm('configB'); ?>

	})
</script>	

@stop