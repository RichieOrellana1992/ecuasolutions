@extends('layouts.app')


@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">

		<div class="sbox">
			<div class="sbox-title">
				<h1> {{ $pageTitle }} <small> {{ $pageNote }} </small></h1>
			</div>
			<div class="sbox-content">

	 @include('katana.config.tab',array('active'=>'translation'))
 	{!! Form::open(array('url'=>'katana/config/translation/', 'class'=>'form-vertical row')) !!}
		
		<div class="col-sm-9">
		
			<a href="{{ URL::to('katana/config/addtranslation')}} " onclick="SximoModal(this.href,'Agregar nuevo idioma');return false;" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo </a>
			<hr />
			<table class="table table-striped">
				<thead>
					<tr>
						<th> Nombre </th>
						<th> Carpeta </th>
						<th> Autor </th>
						<th> Acciones </th>
					</tr>
				</thead>
				<tbody>		
			
				@foreach(SiteHelpers::langOption() as $lang)
					<tr>
						<td>  {{  $lang['name'] }}   </td>
						<td> {{  $lang['folder'] }} </td>
						<td> {{  $lang['author'] }} </td>
					  	<td>
						@if($lang['folder'] !='en')
						<a href="{{ URL::to('katana/config/translation?edit='.$lang['folder'])}} " class="btn btn-sm btn-primary"> Administrar </a>
						<a href="{{ URL::to('katana/config/removetranslation/'.$lang['folder'])}} " class="btn btn-sm btn-danger"> Eliminar </a>
						 
						@endif 
					
					</td>
					</tr>
				@endforeach
				
				</tbody>
			</table>
		</div>

		{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection