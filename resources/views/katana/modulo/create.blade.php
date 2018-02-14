@extends('layouts.app')

@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">

		<div class="sbox">
			<div class="sbox-title">
				 <h4 class="page-title">{{ $pageTitle }} <small> {{ $pageNote }} </small> </h4>
			</div>
			<div class="sbox-content">

{!! Form::open(array('url'=>'katana/modulo/create/', 'class'=>'form-horizontal validated', 'parsley-validate'=>'','novalidate'=>'')) !!}

	
      <div class="form-group">
		<label class="col-sm-3 text-right"></label>
		<div class="col-sm-9">	
	  
			<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul> 
		
		</div>	  
      </div>	

	<div class="form-group has-feedback">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modtitle') }} </label>
		<div class="col-sm-9">	
	  {!! Form::text('modulo_titulo', null, array('class'=>'form-control input-sm', 'placeholder'=>'Nombre del Titulo', 'required'=>'true')) !!}
		</div>
	</div>		
	
	<div class="form-group ">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modnote') }}  </label>
		<div class="col-sm-9">	
	  {!! Form::text('modulo_nota', null, array('class'=>'form-control input-sm', 'placeholder'=>'Breve descripción del módulo')) !!}
		
		</div>
	</div>

	<div class="form-group ">
		<label class="col-sm-3 text-right"> Template :  </label>
		<div class="col-sm-9">	
			@foreach($cruds as $crud)
			<label class="" style="font-weight: 300;">	

				<input type="radio" name="modulo_template" value="{{ $crud->type }}" checked="checked" class="minimal-red" />
				<label style="font-size: 14px;"> {{ $crud->name }} </label>   <br />
				<small > {{ $crud->note }} </small> 
			</label> <br />
			@endforeach
		</div>
	</div>		


	<div class="form-group ">
		<label class="col-sm-3 text-right">Controlador </label>
		<div class="col-sm-9">	
	  {!! Form::text('modulo_nombre', null, array('class'=>'form-control input-sm', 'placeholder'=>'Controlador/Nombre del Módulo' ,  'required'=>'true')) !!}
		
		</div>
	</div>	
		
	
	<div class="form-group">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modtable') }}  </label>
		<div class="col-sm-9">	
		{!! Form::select('modulo_db', $tables , '' ,
			array('class'=>'form-control input-sm', 'required'=>'true' )); 
		!!}
	 	
		</div>
	</div>	
		
	<div class="form-group " style="display:none;">
		<label class="col-sm-3 text-right">Autor </label>
		<div class="col-sm-9">	
	  {!! Form::text('modulo_author',  null, array('class'=>'form-control input-sm', 'placeholder'=>'Autor')) !!}
		
		</div>
	</div>	
		


	<div class="form-group switchSql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">	
			<label class="">
				<input type="radio" name="creation" value="auto"  checked="checked"  class="minimal-red"/> 
				<label>{{ Lang::get('core.fr_modautosql') }} </label>
			</label>		
			<label class="">
				<input type="radio" name="creation" value="manual"  class="minimal-red" />
				<label>{{ Lang::get('core.fr_modmanualsql') }}</label>
			</label>		
		</div>
	</div>	
	
	<div class="form-group manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			{!! Form::textarea('sql_select', null, array('class'=>'form-control', 'placeholder'=>'SQL Select & Join Statement' ,'rows'=>'3' ,'id'=>'sql_select')) !!}
		  
		</div> 
	</div>	
	
	<div class="form-group manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
		{!! Form::textarea('sql_where', null, array('class'=>'form-control', 'placeholder'=>'SQL Where Statement' ,'rows'=>'2','id'=>'sql_where')) !!}
		</div> 
	</div>		

	<div class="form-group manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			{!! Form::textarea('sql_group', null, array('class'=>'form-control', 'placeholder'=>'SQL Grouping Statement' ,'rows'=>'2')) !!}
		</div> 
	</div>	
	
		
      <div class="form-group">
		<label class="col-sm-3 text-right">&nbsp;</label>
		<div class="col-sm-9">	
	  	<button type="submit" class="btn btn-primary "><i class="icon-checkmark-circle2"></i>  {{ Lang::get('core.sb_submit') }}</button>
	  	<a href="{{ url('katana/modulo')}}" class="btn btn-warning"> <i class="icon-backward"></i> Cancel </a>
		</div>	  

      </div>
  </div>
    
    </div>
 {!! Form::close() !!}


			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function(){



		$('.manualsql').hide();
		$('.switchSql input:radio').on('ifClicked', function() {
		  val = $(this).val(); 
			if(val == 'manual')
			{
				$('.manualsql').show();
				$('#sql_select').attr("required","true");
				$('#sql_where').attr("required","true");
				
			} else {
				$('.manualsql').hide();
				$('#sql_select').removeAttr("required");
				$('#sql_where').removeAttr("required");
	
			}		  
		  
		});

	});
	
</script>
@stop
