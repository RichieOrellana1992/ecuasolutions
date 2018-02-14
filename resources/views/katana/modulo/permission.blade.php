@extends('layouts.app')

@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">
		<div class="sbox">
			<div class="sbox-title">
				<h1> {{ $pageTitle }} <small>Configuración</small></h1>
			</div>
			<div class="sbox-content">

{!! Form::open(array('url'=>'katana/modulo/savepermission/'.$modulo_nombre, 'class'=>'form-horizontal' ,'id'=>'fPermission')) !!}


	@include('katana.modulo.tab',array('active'=>'permission','type'=>$type))

		<table class="table table-striped " id="table">
		<thead class="no-border">
  <tr>
	<th field="name1" width="20">No</th>
	<th field="name2">Grupo </th>
	<?php foreach($tasks as $item=>$val) {?>	
	<th field="name3" data-hide="phone"><?php echo $val;?> </th>
	<?php }?>

  </tr>
</thead>  
<tbody class="no-border-x no-border-y">	
  <?php $i=0; foreach($access as $gp) {?>	
  	<tr>
		<td  width="20"><?php echo ++$i;?>
		<input type="hidden" name="grupo_id[]" value="<?php echo $gp['grupo_id'];?>" /></td>
		<td ><?php echo $gp['grupo_codigo'];?> </td>
		<?php foreach($tasks as $item=>$val) {?>	
		<td  class="">
		
		<label >
			<input name="<?php echo $item;?>[<?php echo $gp['grupo_id'];?>]" class="c<?php echo $gp['grupo_id'];?> minimal-red" type="checkbox"  value="1"
			<?php if($gp[$item] ==1) echo ' checked="checked" ';?> />
		</label>	
		</td>

		<?php }?>
	</tr>  
	<?php }?>
  </tbody>
</table>	

<div class="infobox infobox-danger fade in">
  <button type="button" class="close" data-dismiss="alert"> x </button>
  <h5>Información útil !</h5>
  <ol> 
  	<li> Si deseas que los usuarios <strong>solo</strong> puedan acceder a sus propios registros , entonces <strong>Global</strong> debe estar <code>desmarcado</code> </li>
	<li> Cuando se usa esta caracteristica, la tabla de la base de datos debe tener en campo <strong><code>creado_por</code></strong></li>
	</ol>	
</div>	
<button type="submit" class="btn btn-success"> Guardar Cambios </button>
	
<input name="modulo_id" type="hidden" id="modulo_id" value="<?php echo $row->modulo_id;?>" />

 {!! Form::close() !!}	
	


			</div>
		</div>
	</div>
</div>




<script>
	$(document).ready(function(){
	
		$(".checkAll").click(function() {
			var cblist = $(this).attr('rel');
			var cblist = $(cblist);
			if($(this).is(":checked"))
			{				
				cblist.prop("checked", !cblist.is(":checked"));
			} else {	
				cblist.removeAttr("checked");
			}	
			
		});  	
	});
</script>

<script type="text/javascript">
  $(document).ready(function(){

    <?php echo KatanaHelpers::sjForm('fPermission'); ?>

  })
</script> 

@stop