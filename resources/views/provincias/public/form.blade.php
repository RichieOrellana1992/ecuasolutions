

		 {!! Form::open(array('url'=>'provincias/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Provincias</legend>
				{!! Form::hidden('provincia_id', $row['provincia_id']) !!}					
									  <div class="form-group  " >
										<label for="Pais Id" class=" control-label col-md-4 text-right"> Pais Id </label>
										<div class="col-md-6">
										  <select name='pais_id' rows='5' id='pais_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Codigo Provincia" class=" control-label col-md-4 text-right"> Codigo Provincia </label>
										<div class="col-md-6">
										  <input  type='text' name='codigo_provincia' id='codigo_provincia' value='{{ $row['codigo_provincia'] }}' 
						     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Descripcion" class=" control-label col-md-4 text-right"> Descripcion </label>
										<div class="col-md-6">
										  <input  type='text' name='descripcion' id='descripcion' value='{{ $row['descripcion'] }}' 
						     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Activo" class=" control-label col-md-4 text-right"> Activo </label>
										<div class="col-md-6">
										  <input  type='text' name='activo' id='activo' value='{{ $row['activo'] }}' 
						     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="F Modificacion" class=" control-label col-md-4 text-right"> F Modificacion </label>
										<div class="col-md-6">
										  <input  type='text' name='f_modificacion' id='f_modificacion' value='{{ $row['f_modificacion'] }}' 
						     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="F Creacion" class=" control-label col-md-4 text-right"> F Creacion </label>
										<div class="col-md-6">
										  <input  type='text' name='f_creacion' id='f_creacion' value='{{ $row['f_creacion'] }}' 
						     class='form-control input-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				  </div>	  
			
		</div> 
		 <input type="hidden" name="action_task" value="public" />
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#pais_id").jCombo("{!! url('provincias/comboselect?filter=tb_pais:pais_id:descripcion') !!}",
		{  selected_value : '{{ $row["pais_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
