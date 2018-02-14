@extends('layouts.app')

@section('content')
<section class="page-header row">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2>
	<ol class="breadcrumb">
		<li><a href="{{ url('') }}"> Dashboard </a></li>
		<li><a href="{{ url($pageModule) }}"> {{ $pageTitle }} </a></li>
		<li class="active"> View  </li>		
	</ol>
</section>

<div class="page-content row">
	<div class="page-content-wrapper no-margin">

		<div class="sbox">
			<div class="sbox-title clearfix">
				<div class="sbox-tools pull-left" >
			   		<a href="{{ ($prevnext['prev'] != '' ? url('core/usuarios/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
					<a href="{{ ($prevnext['next'] != '' ? url('core/usuarios/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
				</div>	
				<div class="sbox-tools" >

					<a href="{{ url('core/usuarios?return='.$return) }}" class="tips btn btn-sm "  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 		
				</div>

			</div>
			<div class="sbox-content">

	<table class="table table-striped" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Avatar</td>
						<td>
							<?php if( file_exists( './uploads/usuarios/'.$row->avatar) && $row->avatar !='') { ?>
							<img src="{{ URL::to('uploads/usuarios').'/'.$row->avatar }} " border="0" width="40" class="img-circle" />
							<?php  } else { ?> 
							<img alt="" src="http://www.gravatar.com/avatar/{{ md5($row->email) }}" width="40" class="img-circle" />
							<?php } ?>	
						</td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Grupo</td>
						<td>{{ SiteHelpers::gridDisplayView($row->grupo_id,'group_id','1:tb_grupos:grupo_id:codigo') }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Username</td>
						<td>{{ $row->username}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nombres</td>
						<td>{{ $row->nombres }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Apellidos</td>
						<td>{{ $row->apellidos }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Correo Electrónico</td>
						<td>{{ $row->email }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fecha de creacion</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ultimo Ingreso</td>
						<td>{{ $row->ultimo_login }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fecha de modificación</td>
						<td>{{ $row->updated_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Activo</td>
						<td>{!! ($row->activo ==1 ? '<label class="label label-success">Activo</label>' : '<lable class="label label-danger">Inactivo</label>')  !!} </td>
					</tr>
				
		</tbody>	
	</table>    


			</div>
		</div>
	</div>
</div>

	  
@stop