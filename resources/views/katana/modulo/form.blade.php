@extends('layouts.app')

@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">

		<div class="sbox">
			<div class="sbox-title">
				 <h1> {{ $pageTitle }} <small>Configuration</small></h1>
			</div>
			<div class="sbox-content">

	@include('katana.modulo.tab',array('active'=>'form','type'=>$type))

<ul class="nav nav-tabs" style="margin-bottom:10px;">
  	<li class="active" ><a href="{{ URL::to('katana/modulo/form/'.$modulo_nombre)}}">Configuración del Formulario </a></li>
  	<li  ><a href="{{ URL::to('katana/modulo/subform/'.$modulo_nombre)}}">Sub Formulario </a></li>
	<li ><a href="{{ URL::to('katana/modulo/formdesign/'.$modulo_nombre)}}">Diseño del Formulario</a></li>
	
</ul>


 {!! Form::open(array('url'=>'katana/modulo/saveform/'.$modulo_nombre, 'class'=>'form-horizontal','id'=>'fForm')) !!}
 <div class="table-responsive">
		<table class="table table-striped" id="table">
		<thead class="no-border">
          <tr >
            <th scope="col">No</th>
            <th scope="col">Campo</th>
            <th scope="col" width="70"> Limite</th>
            <th scope="col" data-hide="phone">Titulo / Caption </th>

			<th scope="col" data-hide="phone">Tipo </th>
            <th scope="col" data-hide="phone">Mostrar</th>
            
            <th scope="col" data-hide="phone">Buscar</th>
			<th scope="col" data-hide="phone">Validacion</th>
            <th scope="col">&nbsp;</th>
          </tr>
		  </thead>
		  <tbody class="no-border-x no-border-y">	
		  <?php usort($forms, "SiteHelpers::_sort"); ?>
		  <?php $i=0; foreach($forms as $rows){
		  $id = ++$i;
		  ?>
          <tr>
            <td  class="index"><?php echo $id;?></td>
            <td><?php echo $rows['field'];?></td>
			<td>
				<?php
					 $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
				?>
				<input type="text" class="form-control input-sm" name="limited[<?php echo $id;?>]" class="limited" value="<?php echo $limited_to;?>" />

			</td>            
			<td>
				<div class="input-group input-group-sm">
				<span class="input-group-addon xlick bg-default btn-xs " >ES</span>
				<input type="text" name="label[<?php echo $id;?>]" class="form-control input-sm" value="<?php echo $rows['label'];?>" />
				
              </div>
					@if($config->lang =='true')
				  <?php $lang = SiteHelpers::langOption();
				  if($ktnconfig['cnf_multilang'] ==1) {
					foreach($lang as $l) { if($l['folder'] !='es') {
				   ?>
				   <div class="input-group input-group-sm" style="margin:1px 0 !important;">
				   <span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
					 <input name="language[<?php echo $id;?>][<?php echo $l['folder'];?>]" type="text" class="form-control input-sm " 
					 value="<?php echo (isset($rows['language'][$l['folder']]) ? $rows['language'][$l['folder']] : '');?>"
					 placeholder="Etiqueta en <?php echo ucwords($l['name']);?>"
					  />
					 
				  </div>
				  <?php } } }?>	
				  @endif			
			</td>

			<td>
            <?php echo $rows['type'];?>
			<input type="hidden" name="type[<?php echo $id;?>]" value="<?php echo $rows['type'];?>" />
			</td>
            <td>
			<label >
            <input type="checkbox" name="view[<?php echo $id;?>]" value="1"  class="minimal-red"
			<?php if($rows['view'] == 1) echo 'checked="checked"';?> />
			</label>
			</td>
            
            <td>
			<label >
            <input type="checkbox" name="search[<?php echo $id;?>]" value="1" class="minimal-red"
			<?php if($rows['search'] == 1) echo 'checked="checked"';?>
			/>
			</label>
			</td>
			<td>
				<input type="text" name="required[<?php echo $id;?>]" class="form-control input-sm" value="{{ $rows['required'] }}" />
				
		</td>
            <td>
			<a href="javascript:void(0)" class="btn btn-xs btn-success btn-outline editForm"  role="button"  
			onclick="SximoModal('{{ URL::to('katana/modulo/editform/'.$row->modulo_id.'?field='.$rows['field'].'&alias='.$rows['alias']) }}','Edit Field : <?php echo $rows['field'];?>')">
			<i class="icon-menu"></i></a>

			
			
			<input type="hidden" name="alias[<?php echo $id;?>]" value="<?php echo $rows['alias'];?>" />
			<input type="hidden" name="field[<?php echo $id;?>]" value="<?php echo $rows['field'];?>" />	
			<input type="hidden" name="form_group[<?php echo $id;?>]" value="<?php echo $rows['form_group'];?>" />	
			<input type="hidden" name="sortlist[<?php echo $id;?>]" class="reorder" value="<?php echo $rows['sortlist'];?>" />		
			<input type="hidden" name="opt_type[<?php echo $id;?>]" value="<?php echo $rows['option']['opt_type'];?>" />
			<input type="hidden" name="lookup_query[<?php echo $id;?>]" value="<?php echo $rows['option']['lookup_query'];?>" />
			<input type="hidden" name="lookup_table[<?php echo $id;?>]" value="<?php echo $rows['option']['lookup_table'];?>" />
			<input type="hidden" name="lookup_key[<?php echo $id;?>]" value="<?php echo $rows['option']['lookup_key'];?>" />
			<input type="hidden" name="lookup_value[<?php echo $id;?>]" value="<?php echo $rows['option']['lookup_value'];?>" />
			<input type="hidden" name="is_dependency[<?php echo $id;?>]" value="<?php echo $rows['option']['is_dependency'];?>" />
			<input type="hidden" name="lookup_dependency_key[<?php echo $id;?>]" value="<?php echo $rows['option']['lookup_dependency_key'];?>" />
			<input type="hidden" name="path_to_upload[<?php echo $id;?>]" value="<?php echo $rows['option']['path_to_upload'];?>" />
			<input type="hidden" name="upload_type[<?php echo $id;?>]" value="<?php echo $rows['option']['upload_type'];?>" />
			<input type="hidden" name="resize_width[<?php echo $id;?>]" value="<?php if(isset($rows['option']['resize_width'])) echo $rows['option']['resize_width'];?>" />
			<input type="hidden" name="resize_height[<?php echo $id;?>]" value="<?php if(isset($rows['option']['resize_height'])) echo $rows['option']['resize_height'];?>" />
			<input type="hidden" name="extend_class[<?php echo $id;?>]" value="<?php if(isset($rows['option']['resize_height'])) echo $rows['option']['resize_height'];?>" />
			<input type="hidden" name="tooltip[<?php echo $id;?>]" value="<?php if(isset($rows['option']['tooltip'])) echo $rows['option']['tooltip'];?>" />
			<input type="hidden" name="attribute[<?php echo $id;?>]" value="<?php if(isset($rows['option']['attribute'])) echo $rows['option']['attribute'];?>" />
			<input type="hidden" name="extend_class[<?php echo $id;?>]" value="<?php if(isset($rows['option']['extend_class'])) echo $rows['option']['extend_class'];?>" />
			<input type="hidden" name="select_multiple[<?php echo $id;?>]" value="<?php if(isset($rows['option']['select_multiple'])) echo $rows['option']['select_multiple'];?>" />
			<input type="hidden" name="image_multiple[<?php echo $id;?>]" value="<?php if(isset($rows['option']['image_multiple'])) echo $rows['option']['image_multiple'];?>" />
			
			</td>
			
          </tr>
		  <?php } ?>
		  </tbody>
        </table>
		</div>

 <div class="infobox infobox-danger fade in">
  <button type="button" class="close" data-dismiss="alert"> x </button>  
  <p> <strong>Note !</strong> La clave primaria debe estar <strong>visible</strong> y ser de tipo <strong>hidden</strong> </p>
</div>		
		
		<button type="submit" class="btn btn-primary"> Guardar Cambios </button>
		<input type="hidden" name="modulo_id" value="{{ $row->modulo_id }}" />
 {!! Form::close() !!}		


			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	
	$('.expand-row').hide();
	$('.btn-sm').click(function(){
		var id = $(this).attr('rel');
		$('.expand-row').hide();
		$(id).slideDown(100);
		
	});
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index) {
			$(this).width($originals.eq(index).width())
		});
		return $helper;
		},
		updateIndex = function(e, ui) {
			$('td.index', ui.item.parent()).each(function (i) {
				$(this).html(i + 1);
			});
			$('.reorder', ui.item.parent()).each(function (i) {
				$(this).val(i + 1);
			});			
		};
		
	$("#table tbody").sortable({
		helper: fixHelperModified,
		stop: updateIndex
	});		
});


</script>
<script type="text/javascript">
  $(document).ready(function(){

    <?php echo KatanaHelpers::sjForm('fForm'); ?>

  })
</script>
@stop