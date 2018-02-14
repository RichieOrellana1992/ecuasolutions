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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Parroquia Id', (isset($fields['parroquia_id']['language'])? $fields['parroquia_id']['language'] : array())) }}</td>
						<td>{{ $row->parroquia_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Canton Id', (isset($fields['canton_id']['language'])? $fields['canton_id']['language'] : array())) }}</td>
						<td>{{ $row->canton_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Codigo Parroquia', (isset($fields['codigo_parroquia']['language'])? $fields['codigo_parroquia']['language'] : array())) }}</td>
						<td>{{ $row->codigo_parroquia}} </td>
						
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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Codigo Canton', (isset($fields['codigo_canton']['language'])? $fields['codigo_canton']['language'] : array())) }}</td>
						<td>{{ $row->codigo_canton}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	