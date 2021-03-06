@extends('layouts.app')

@section('content')
<div class="page-content row">
	<div class="page-content-wrapper m-t">

		<div class="sbox">
			<div class="sbox-title">
				<h1> {{ $pageTitle }}  <small> {{ $pageNote }} </small> </h1>
			</div>
			<div class="sbox-content clearfix">

			@include('katana.config.tab')
	 		{!! Form::open(array('url'=>'katana/config/login/', 'class'=>'form-horizontal validated')) !!}

			<div class="col-sm-6">
				

		 		  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">  {{ Lang::get('core.fr_emailsys') }}  </label>	
					<div class="col-sm-8 ">
							
							<div class="">
								<input type="radio" name="CNF_MAIL" value="phpmail"   @if($ktnconfig['cnf_mail'] =='phpmail') checked @endif class="minimal-red"  />
								<label>PHP MAIL System</label>
							</div>
							
							<div class="">
								<input type="radio" name="CNF_MAIL" value="swift"   @if($ktnconfig['cnf_mail'] =='swift') checked @endif class="minimal-red"  />
								<label>SWIFT Mail ( Required Configuration )</label>
							</div>			
					</div>
				</div>					
		  
				  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_registrationdefault') }}  </label>	
					<div class="col-sm-8">
							<div >
								
								<select class="form-control" name="CNF_GROUP">
									@foreach($groups as $group)
									<option value="{{ $group->group_id }}"
									 @if($ktnconfig['cnf_group'] == $group->grupo_id ) selected @endif
									>{{ $group->codigo }}</option>
									@endforeach
								</select>
								
							</div>				
					</div>	
							
				  </div> 

				  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">{{ Lang::get('core.fr_registration') }} </label>	
					<div class="col-sm-8 " >
						<div class=" radio-success">
							
							<div class="">
							<input type="radio" name="CNF_ACTIVATION" value="auto" @if($ktnconfig['cnf_activation'] =='auto') checked @endif  class="minimal-red"  />
							<label>{{ Lang::get('core.fr_registrationauto') }}</label>
							</div>
							
							<div class=" ">
								<input type="radio" name="CNF_ACTIVATION" value="manual" @if($ktnconfig['cnf_activation'] =='manual') checked @endif   class="minimal-red" />
								<label>{{ Lang::get('core.fr_registrationmanual') }}</label>
							</div>								
							<div class=" ">
								<input type="radio" name="CNF_ACTIVATION" value="confirmation" @if($ktnconfig['cnf_activation'] =='confirmation') checked @endif  class="minimal-red"  />
								<label>{{ Lang::get('core.fr_registrationemail') }}</label>
							</div>
						</div>						
									
					</div>	
							
				  </div> 
				  
		 		  <div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowregistration') }} </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="checkbox" name="CNF_REGIST" value="true"  @if($ktnconfig['cnf_regist'] =='true') checked @endif class="minimal-red"  />
							<label>{{ Lang::get('core.fr_enable') }}</label>
						</div>			
					</div>
				</div>	
				
		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> {{ Lang::get('core.fr_allowfrontend') }} </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="checkbox" name="CNF_FRONT" value="false" @if($ktnconfig['cnf_front'] =='true') checked @endif class="minimal-red"  />
							<label>{{ Lang::get('core.fr_enable') }}</label>
						</div>			
					</div>
				</div>		
			
		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4">Google reCaptcha </label>	
					<div class="col-sm-8">
						<div class="">
						
							<input type="checkbox" name="cnf_recaptcha" value="false" @if(config('ktn.cnf_recaptcha') =='true') checked @endif class="minimal-red"  />  {{ Lang::get('core.fr_enable') }}
							<br /><br />

							<label> Site key</label>
							<input type="text" name="cnf_recaptchapublickey" value="{{ config('ktn.cnf_recaptchapublickey') }}" class="input-sm form-control"  /> 
							<label> Secret key</label>
							<input type="text" name="cnf_recaptchaprivatekey" value="{{ config('ktn.cnf_recaptchaprivatekey') }}" class="input-sm form-control"  /> 
							
						</div>	
												
					</div>
				</div>		
				

		 		<div class="form-group">
					<label for="ipt" class=" control-label col-sm-4"> Google Maps API Key </label>	
					<div class="col-sm-8">
						<div class="">
							<input type="text" name="CNF_MAPS" value="{{ config('ktn.cnf_maps') }}" class="input-sm form-control"  /> 
							<small><i>* This is required if you use google Maps form .</i></small>
						</div>	
												
					</div>
				</div>		
				

			  	<div class="form-group">
					<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
					<div class="col-md-8">
						<button class="btn btn-primary" type="submit"> {{ Lang::get('core.sb_savechanges') }}</button>
				 	</div>
			  	</div>	  
			
		 	</div>

			<div class="col-sm-6">	
				<div class="form-vertical">
					<div class="form-group">
						<label> {{ Lang::get('core.fr_restrictip') }} </label>	
						
						<p><small><i>
							
							{{ Lang::get('core.fr_restrictipsmall') }}  <br />
							{{ Lang::get('core.fr_restrictipexam') }} : <code> 192.116.134 , 194.111.606.21 </code>
						</i></small></p>
						<textarea rows="5" class="form-control" name="CNF_RESTRICIP">{{ $ktnconfig['cnf_restrictip'] }}</textarea>
					</div>
					
					<div class="form-group">
						<label> {{ Lang::get('core.fr_allowip') }} </label>	
						<p><small><i>
							
							{{ Lang::get('core.fr_allowipsmall') }}  <br />
							{{ Lang::get('core.fr_allowipexam') }} : <code> 192.116.134 , 194.111.606.21 </code>
						</i></small></p>							
						<textarea rows="5" class="form-control" name="CNF_ALLOWIP">{{ $ktnconfig['cnf_allowip'] }}</textarea>
					</div>

					<p> {{ Lang::get('core.fr_ipnote') }} </p>
				</div>
			</div>
			{!! Form::close() !!}


			</div>
		</div>
	</div>
</div>


@stop




