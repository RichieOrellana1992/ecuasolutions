 {!! Form::open(array('url'=>'katana/config/addtranslation/', 'class'=>'form-horizontal validated')) !!}
 <div class="">
    <div class="form-group">
      <label for="ipt" class=" control-label col-md-4"> Idioma </label>
    	<div class="col-md-8">
    	<input name="name" type="text" id="name" class="form-control input-sm" value="" required="true" /> 
    	</div> 
    </div>   	
   
    <div class="form-group">
      <label for="ipt" class=" control-label col-md-4"> Nombre de la Carpeta </label>
  	<div class="col-md-8">
  	<input name="folder" type="text" id="folder" class="form-control input-sm" value="" required /> 
  	 </div> 
    </div>   	
    
     <div class="form-group">
      <label for="ipt" class=" control-label col-md-4"> Autor </label>
  	<div class="col-md-8">
  	<input name="author" type="text" id="author" class="form-control input-sm" value="" required /> 
  	 </div> 
    </div>   	
    
    <div class="form-group">
      <label for="ipt" class=" control-label col-md-4">  </label>
    	<div class="col-md-8">
    		<button type="submit" name="submit" class="btn btn-info"> Agregar Idioma</button>
    	</div> 
    </div>  
  </div> 	    
 
 {!! Form::close() !!}