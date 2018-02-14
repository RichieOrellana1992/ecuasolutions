 {!! Form::open(array('url'=>'katana/modulo/dobuild/'.$modulo_nombre, 'class'=>'form-horizontal','id'=>'rebuildForm')) !!}
    <div class="text-center result"></div>
    <p class="text-center" style="font-weight: bold;">
        <b> Construir todos el codigos </b> <br />
        <span class="text-center"> <i class="icon-arrow-down3"></i> </span>
    </p>
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">  </label>
    <div class="col-md-8">
      <a href="{{ url('katana/modulo/rebuild/'.$modulo_id)}}" class="btn btn-danger" id="rebuild" ><i class="fa fa-repeat"></i> Reconstruir todo </a>
      </div>
  </div> 
<hr />
    <p class="text-center " style="font-weight: bold;">
    <b>Compilar codigo por separado</b> <br />
        <span class="text-center"> <i class="icon-arrow-down3"></i> </span>
    </p>
 <h5> Vistas de BackEnd </h5>
  <hr />
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Controlador </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="controlador" type="checkbox" id="controlador" value="1">
	  <code> {{ ucwords($modulo) }}Controlador.php </code> <br />será reemplazado con código nuevo
	  </label>
	 </div> 
  </div>  

  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Modelo </label>
	<div class="col-md-8">
	  <label class="">
	  	<input name="modelo" type="checkbox" id="modelo" value="1">
		 <code>{{ ucwords($modulo) }}.php</code> Modelo <br />será reemplazado con código nuevo
	  </label>
	 </div> 
  </div>  
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Tabla </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="tabla" type="checkbox" id="tabla" value="1">
	  <code>index.blade.php</code>  at <code>views/{{ $modulo }}/ </code> carpeta <br /> será reemplazado con código nuevo 
	  </label>
	 </div> 
  </div>  

  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Formulario </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="formulario" type="checkbox" id="formulario" value="1" checked>
	  <code>form.blade.php</code>  at <code>views/{{ $modulo }}/ </code> carpeta <br /> será reemplazado con código nuevo 
	 
	  </label>
	 </div> 
  </div>        
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">Ver Detalles  </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="ver" type="checkbox" id="ver" value="1" checked>
     <code>view.blade.php</code>  en <code>views/{{ $modulo }}/ </code> carpeta <br /> será reemplazado con código nuevo
	  </label>
	   <input name="rebuild" type="hidden" id="rebuild" value="ok">
	   <input name="modulo_id" type="hidden" id="modulo_id" value="{{ $modulo_id}}">
	 </div> 
  </div>   
	<hr />
 <h5> Vistas de FrontEnd</h5>
  	<hr />
  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">FrontEnd Tabla   </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="fronttabla" type="checkbox" id="fronttabla" value="1" >
     <code>index.blade.php</code>  en <code>views/{{ $modulo }}/public/ </code> carpeta <br /> será reemplazado con código nuevo
	  </label>
	   
	 </div> 
  </div>

    <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">FrontEnd Ver detalles  </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="frontver" type="checkbox" id="frontver" value="1" >
     <code>view.blade.php</code>  en <code>views/{{ $modulo }}/public/ </code> carpeta <br /> será reemplazado con código nuevo
	  </label>
	  
	 </div> 
  </div>

   <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">FrontEnd Formulario  </label>
	<div class="col-md-8">
	  <label class="">
	  <input name="frontform" type="checkbox" id="frontform" value="1" >
     <code>form.blade.php</code>  en <code>views/{{ $modulo }}/public </code> carpeta <br /> será reemplazado con código nuevo
	  </label>
	   
	 </div> 
  </div> 


   <div class="form-group">
    <label for="ipt" class=" control-label col-md-4"></label>
	<div class="col-md-8">
	  <button type="submit" name="submit" id="submitRbld" class="btn btn-sm btn-danger"> Reconstruir ahora</button>
	 </div> 
  </div>       

 {!! Form::close() !!}
 <script type="text/javascript">
	$(function(){

        $('#rebuild').click(function () {
            var url = $(this).attr("href");
            $(this).html('<i class="icon-spinner7"></i> Procesando .... ');
            $.get(url, function( data ) {
              $( ".result" ).html( '<p class="alert alert-success">'+data.message+'</p>' );
             $('#rebuild').html('<i class="icon-spinner7"></i>  Reconstruir todo ');
            });
            return false;
        })
        /*
		$('input[type="checkbox"],input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_square-red',
			radioClass: 'iradio_square-red',
		});	
		*/

		$('#rebuildForm').submit(function(){
			var act = $(this).attr('action');
			 $('#submitRbld').html('<i class="icon-spinner7"></i> Procesando .... ');
			$.post(act,$(this).serialize(),
			    function(data){
			    	if(data.status=='success')
			    	{
			    		$.get(data.url, function( json ) {
				            $( ".result" ).html( '<p class="alert alert-success">'+json.message+'</p>' );
				            $('#submitRbld').html('<i class="icon-spinner7"></i>  Reconstruir ahora ');
				             alert(json.message)
				        });	
			    	}
			      
			    }, "json");
			return false;
		});
		
	})
 </script>

