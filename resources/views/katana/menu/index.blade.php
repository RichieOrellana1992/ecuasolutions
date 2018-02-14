@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('katana/js/plugins/jquery.nestable.js') }}"></script>
<section class="page-header row">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2>
	<ol class="breadcrumb">
		<li><a href="{{ url('') }}"> Dashboard </a></li>
		<li class="active"> {{ $pageTitle }} </li>		
	</ol>
</section>
<div class="page-content row">
	<div class="page-content-wrapper no-margin">
		<div class="sbox"  >
			<div class="sbox-title" >   
				 <h1> {{ $pageTitle }} <small> {{ $pageNote }} </small></h1>
			</div>
			<div class="sbox-content">
	<ul class="nav nav-tabs" style="margin:10px 0;">
		<li @if($activo == 'top') class="active" @endif ><a href="{{ url('katana/menu?pos=top')}}"> {{ Lang::get('core.tab_topmenu') }} </a></li>
		<li @if($activo == 'sidebar') class="active" @endif><a href="{{ url('katana/menu?pos=sidebar')}}"> {{ Lang::get('core.tab_sidemenu') }}</a></li>	
	</ul>
					
				<div class="col-md-5">
					<fieldset style="min-height: 400px;">
						<legend> Menú de navegación </legend>

<div id="list2" class="dd myadmin-dd-empty " style="min-height:350px;">
              <ol class="dd-list">
			@foreach ($menus as $menu)
				  <li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item">
					<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_nombre']}}
						<span class="pull-right">
						<a href="{{ url('katana/menu/index/'.$menu['menu_id'].'?pos='.$activo)}}"><i class="fa fa-edit"></i></a></span>
					</div>
					@if(count($menu['childs']) > 0)
						<ol class="dd-list" style="">
							@foreach ($menu['childs'] as $menu2)
							 <li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
								<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_nombre']}}
									<span class="pull-right">
									<a href="{{ url('katana/menu/index/'.$menu2['menu_id'].'?pos='.$activo)}}"><i class="fa fa-edit"></i></a></span>
								</div>
								@if(count($menu2['childs']) > 0)
								<ol class="dd-list" style="">
									@foreach($menu2['childs'] as $menu3)
									 	<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
											<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_nombre'] }}
												<span class="pull-right">
												<a href="{{ url('katana/menu/index/'.$menu3['menu_id'].'?pos='.$activo)}}"><i class="fa fa-edit"></i></a>
												</span>
											</div>
										</li>	
									@endforeach
								</ol>
								@endif
							</li>							
							@endforeach
						</ol>
					@endif
				</li>
			@endforeach			  
              </ol>
            </div>
		 {!! Form::open(array('url'=>'katana/menu/saveorder', 'class'=>'form-horizontal','files' => true)) !!}	
			<input type="hidden" name="reorder" id="reorder" value="" />
 <div class="infobox infobox-danger fade in">
 <p> {{ Lang::get('core.t_tipsnote') }}	</p>
</div>			
		
			<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_reorder') }} </button>	
		 {!! Form::close() !!}	


					</fieldset>
				</div>	

				<div class="col-md-7">
					<fieldset style="min-height: 400px;">
						<legend> Crear / Actualizar</legend>



		 {!! Form::open(array('url'=>'katana/menu/save', 'class'=>'form-horizontal','files' => true  , 'parsley-validate'=>'','novalidate'=>' ')) !!}
				

				
				<input type="hidden" name="menu_id" id="menu_id" value="{{ $row['menu_id'] }}" />
				<input type="hidden" name="padre_id" id="padre_id" value="{{ $row['padre_id'] }}" />	
								
				 
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_mtitle') }}  </label>
					<div class="col-md-8">
					  {!! Form::text('menu_nombre', $row['menu_nombre'],array('class'=>'form-control input-sm ', 'placeholder'=>'','required'=>'true')) !!} 
					  @if($ktnconfig['cnf_multilang'] ==1)
					    <?php $lang = SiteHelpers::langOption();
						foreach($lang as $l) { 
							if($l['folder'] !='es') {
							?>
								<div class="input-group input-group-sm" style="margin:1px 0 !important;">
								 <input name="language_title[<?php echo $l['folder'];?>]" type="text"   class="form-control" placeholder="Titulo en <?php echo $l['name'];?>"
								 value="<?php echo (isset($menu_lang['title'][$l['folder']]) ? $menu_lang['title'][$l['folder']] : '');?>" />
								<span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
							   </div> 								
							<?php
							}
						
						}
					   ?>
					  @endif				  
					  
					 </div> 
				  </div> 

				  <div class="form-group   " >
					<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mtype') }}  </label> 
					<div class="col-md-8 menutype">
					
						
					<input type="radio" name="menu_tipo" value="internal" class="minimal-red"   required="true" 
					@if($row['menu_tipo']=='internal  ' || $row['menu_tipo']=='') checked="checked" @endif />
					
					Interno
					
					<input type="radio" name="menu_tipo" value="external"  class="minimal-red" required="true" 

					@if($row['menu_tipo']=='external  ' ) checked="checked" @endif  /> Externo
					  
					 </div> 
				  </div> 

				  			  					
				  <div class="form-group  ext-link" >
					<label for="ipt" class=" control-label col-md-4 text-right"> Url  </label>
					<div class="col-md-8">
					   {!! Form::text('url', $row['url'],array('class'=>'form-control input-sm', 'placeholder'=>' Escribe una Url externa')) !!}
					 </div> 
				  </div> 	


								  					
				  <div class="form-group  int-link" >
					<label for="ipt" class=" control-label col-md-4 text-right"> Controlador / Ruta  </label>
					<div class="col-md-8">
					 		
					
					<select name='modulo' rows='5' id='modulo'  style="width:100%"
							class='form-control input-sm	'    >

							<option value=""> -- Selecciona un Módulo -- </option>
							<option value="separator" @if($row['modulo']== 'separator' ) selected="selected" @endif> Separator Menu </option>
							<optgroup label="Módulo ">
							@foreach($modulos as $mod)
								<option value="{{ $mod->modulo_nombre}}"
								@if($row['modulo']== $mod->modulo_nombre ) selected="selected" @endif
								>{{ $mod->modulo_titulo}}</option>
							@endforeach
							</optgroup>
							{{--<optgroup label="Page CMS ">--}}
							{{--@foreach($pages as $page)--}}
								{{--<option value="{{ $page->alias}}"--}}
								{{--@if($row['module']== $page->alias ) selected="selected" @endif--}}
								{{-->Page : {{ $page->title}}</option>--}}
							{{--@endforeach	--}}
							{{--</optgroup>						--}}
					</select> 
					 </div> 

				  </div> 										
					

				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mposition') }}  </label>
					<div class="col-md-8">
						<div class="">
							<input type="radio" name="posicion"  value="top" required  class="minimal-red"
							@if($row['posicion']=='top' ) checked="checked" @endif /> {{ Lang::get('core.tab_topmenu') }}
						</div>
						<div class="">	
							<input type="radio" name="posicion"  value="sidebar"  required class="minimal-red"
							@if($row['posicion']=='sidebar' ) checked="checked" @endif  /> {{ Lang::get('core.tab_sidemenu') }}
						</div>	
					 </div> 
				  </div> 	 				
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right">{{ Lang::get('core.fr_miconclass') }}  </label>
					<div class="col-md-8">
					  {!! Form::text('menu_iconos', $row['menu_iconos'],array('class'=>'form-control input-sm', 'placeholder'=>'')) !!}
					  <p> {{ Lang::get('core.fr_mexample') }} : <span class="label label-info"> fa fa-desktop </span> </p>
					  <p> Ver códigos de icono :
					  <a href="{{ url('katana/menu/icon')}}" onclick="SximoModal(this.href,'Select Icon'); return false;"> Examinar Iconos  </a>
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> {{ Lang::get('core.fr_mactive') }}  </label>
					<div class="col-md-8 ">
						<div class="">
							<input type="radio" name="activo"  value="1"  class="minimal-red"
							@if($row['activo']=='1' ) checked="checked" @endif /> <label>{{ Lang::get('core.fr_mactive') }} </label>
						</div>
						<div class="">
							<input type="radio" name="activo" value="0"  class="minimal-red"
							@if($row['activo']=='0' ) checked="checked" @endif  /> <label>{{ Lang::get('core.fr_minactive') }} </label>
						</div>	
										
					 
					 </div> 
				  </div> 

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">{{ Lang::get('core.fr_maccess') }}  <code>*</code></label>
				<div class="col-md-8">
						<?php 
					$pers = json_decode($row['datos_acceso'],true);
					foreach($grupos as $grupo) {
						$checked = '';
						if(isset($pers[$grupo->grupo_id]) && $pers[$grupo->grupo_id]=='1')
						{
							$checked= ' checked="checked"';
						}						
							?>		
				  <div class="">
				  <input type="checkbox" name="grupos[<?php echo $grupo->grupo_id;?>]" value="<?php echo $grupo->grupo_id;?>" <?php echo $checked;?> class="minimal-red"  />
				  	<label><?php echo $grupo->codigo;?>  </label>
				  </div>
			
				  <?php } ?>
						 </div> 
			  </div> 

				  
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  {{ Lang::get('core.sb_submit') }}  </button>
				@if($row['menu_id'] !='')
					<button type="button"onclick="SximoConfirmDelete('{{ url('katana/menu/destroy/'.$row['menu_id'].'?pos='.$activo)}}')" class="btn btn-danger ">  Eliminar </button>
				@endif	
				</div>	  
		
			  </div> 
			
		</div>	  
		 
		 {!! Form::close() !!}	

		 			<div class="clr"></div>	
					</fieldset>				
				</div>	
				<div class="clr"></div>	
				
			</div>	
		</div>
	</div>		
</div>
                               
<script>
$(document).ready(function(){
	$('.dd').nestable();
    update_out('#list2',"#reorder");
    
    $('#list2').on('change', function() {
		var out = $('#list2').nestable('serialize');
		$('#reorder').val(JSON.stringify(out));	  

    });
	$('.ext-link').hide(); 

	$('.menutype input:radio').on('ifClicked', function() {
	 	 val = $(this).val();
  			mType(val);
	  
	});
	
	mType('<?php echo $row['menu_tipo'];?>'); 
	
			
});	

function mType( val )
{
		if(val == 'external') {
			$('.ext-link').show(); 
			$('.int-link').hide();
		} else {
			$('.ext-link').hide(); 
			$('.int-link').show();
		}	
}

	
function update_out(selector, sel2){
	
	var out = $(selector).nestable('serialize');
	$(sel2).val(JSON.stringify(out));

}
</script>	
  
@endsection