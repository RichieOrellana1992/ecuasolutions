<div class="m-t" style="padding-top:25px;">	
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
        <hr />       
    </div>
</div>
<div class="m-t">
	<div class="table-responsive" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
			
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Provincia Id', (isset($fields['provincia_id']['language'])? $fields['provincia_id']['language'] : array())) }}</td>
						<td>{{ $row->provincia_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Pais Id', (isset($fields['pais_id']['language'])? $fields['pais_id']['language'] : array())) }}</td>
						<td>{{ $row->pais_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Codigo Provincia', (isset($fields['codigo_provincia']['language'])? $fields['codigo_provincia']['language'] : array())) }}</td>
						<td>{{ $row->codigo_provincia}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Descripcion', (isset($fields['descripcion']['language'])? $fields['descripcion']['language'] : array())) }}</td>
						<td>{{ $row->descripcion}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Activo', (isset($fields['activo']['language'])? $fields['activo']['language'] : array())) }}</td>
						<td>{{ $row->activo}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('F Modificacion', (isset($fields['f_modificacion']['language'])? $fields['f_modificacion']['language'] : array())) }}</td>
						<td>{{ $row->f_modificacion}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('F Creacion', (isset($fields['f_creacion']['language'])? $fields['f_creacion']['language'] : array())) }}</td>
						<td>{{ $row->f_creacion}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Codigo Pais', (isset($fields['codigo_pais']['language'])? $fields['codigo_pais']['language'] : array())) }}</td>
						<td>{{ $row->codigo_pais}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	