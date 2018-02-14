@extends('layouts.app')

@section('content')
<section class="page-header row">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2>
	<ol class="breadcrumb">
		<li><a href="{{ url('') }}"> Dashboard </a></li>
		<li><a href="{{ url($pageModule) }}"> {{ $pageTitle }} </a></li>
		<li class="active"> Formulario  </li>
	</ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">

	{!! Form::open(array('url'=>'provincias?return='.$return, 'class'=>'form-horizontal validated','files' => true )) !!}
	<div class="sbox">
		<div class="sbox-title clearfix">
			<div class="sbox-tools " >
				<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 
			</div>
			<div class="sbox-tools pull-left" >
				<button name="apply" class="tips btn btn-sm btn-apply  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
				<button name="save" class="tips btn btn-sm btn-save"  title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button> 
			</div>
		</div>	
		<div class="sbox-content clearfix">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		
<div class="col-md-12">
						<fieldset><legend> Provincias</legend>
				{!! Form::hidden('provincia_id', $row['provincia_id']) !!}					
									  <div class="form-group  " >
										<label for="País" class=" control-label col-md-4 text-right"> País <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='pais_id' rows='5' id='pais_id' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Código" class=" control-label col-md-4 text-right"> Código <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='codigo_provincia' id='codigo_provincia' value='{{ $row['codigo_provincia'] }}' 
						required     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Descripción" class=" control-label col-md-4 text-right"> Descripción </label>
										<div class="col-md-6">
										  <textarea name='descripcion' rows='5' id='descripcion' class='form-control input-sm '  
				           >{{ $row['descripcion'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Activo" class=" control-label col-md-4 text-right"> Activo </label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='activo' value ='1'  @if($row['activo'] == '1') checked="checked" @endif class='minimal-red' > Activo 
					
					<input type='radio' name='activo' value ='0'  @if($row['activo'] == '0') checked="checked" @endif class='minimal-red' > Inactivo  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

		</div>
	</div>
	<input type="hidden" name="action_task" value="save" />
	{!! Form::close() !!}
	</div>
</div>		
	
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		
		$("#pais_id").jCombo("{!! url('provincias/comboselect?filter=tb_pais:pais_id:descripcion') !!}",
		{  selected_value : '{{ $row["pais_id"] }}' });
		 		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("provincias/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop