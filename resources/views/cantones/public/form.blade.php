

		 {!! Form::open(array('url'=>'cantones/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Formulario</legend>
									
									  <div class="form-group  " >
										<label for="Provincia" class=" control-label col-md-4 text-right"> Provincia </label>
										<div class="col-md-6">
										  <select name='provincia_id' rows='5' id='provincia_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Código" class=" control-label col-md-4 text-right"> Código </label>
										<div class="col-md-6">
										  <input  type='text' name='codigo_canton' id='codigo_canton' value='{{ $row['codigo_canton'] }}' 
						     class='form-control input-sm ' /> 
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
		
		
		$("#provincia_id").jCombo("{!! url('cantones/comboselect?filter=tb_provincia:provincia_id:descripcion') !!}",
		{  selected_value : '{{ $row["provincia_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
