@extends('layouts.app')

@section('content')
<section class="page-header row">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2>
	<ol class="breadcrumb">
		<li><a href="{{ url('') }}"> Dashboard </a></li>
		<li><a href="{{ url($pageModule) }}"> {{ $pageTitle }} </a></li>
		<li class="active"> Form  </li>		
	</ol>
</section>
<div class="page-content  row">
	<div class="page-content-wrapper no-margin">

	<div class="sbox">
		<div class="sbox-title">
			<h1> Form Update </h1>
			<div class="sbox-tools" >
				<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-sm  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 
			</div>

		</div>	
		<div class="sbox-content">

		 {!! Form::open(array('url'=>'core/grupos?return='.$return, 'class'=>'form-horizontal validated','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Group Id" class=" control-label col-md-4 text-right"> Grupo Id </label>
									<div class="col-md-6">
									  {!! Form::text('grupo_id', $row['grupo_id'],array('class'=>'form-control input-sm', 'placeholder'=>'',   )) !!} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Codigo" class=" control-label col-md-4 text-right"> Codigo <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('codigo', $row['codigo'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Descripcion" class=" control-label col-md-4 text-right"> Descripcion </label>
									<div class="col-md-6">
									  <textarea name='descripcion' rows='2' id='descripcion' class='form-control '
				           >{{ $row['descripcion'] }}</textarea>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Nivel" class=" control-label col-md-4 text-right"> Nivel <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {!! Form::text('nivel', $row['nivel'],array('class'=>'form-control input-sm', 'placeholder'=>'', 'required'=>'true'  )) !!}
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
			
			
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('core/grupos?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 	<input type="hidden" name="action_task" value="save" />
		 	{!! Form::close() !!}
		</div>
	</div>
	</div>
</div>	
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 
@stop