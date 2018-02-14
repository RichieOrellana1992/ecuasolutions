<?php $sidebar = SiteHelpers::menus('sidebar') ;?>
<div id="sidebar-navigation">
    <div class="logo">
         <a href="<?php echo url('dashboard') ;?>">           
            @if(file_exists(public_path().'/uploads/images/'.config('ktn.cnf_logo') ) && config('ktn.cnf_logo') !='')
                <img src="{{ asset('uploads/images/'.config('ktn.cnf_logo')) }}" alt="{{ config('ktn.cnf_appname') }}"  />
            @else
            {{ config('ktn.cnf_appname')}}
            @endif  
        </a>    
    </div>
    <div class="sidebar-collapse">
    <nav role="navigation" class="navbar-default ">
       <ul id="sidemenu" class="nav expanded-menu">
        <li class="profile-sidebar">
            <a href="{{ url('user/profile')}}">
                {!! SiteHelpers::avatar(80)!!}
            </a>

            <div class="stats-label">
               

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="font-extra-bold font-uppercase">{{ session('fid') }}</span>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs" style="display: none">
                        <li><a href="{{ url('user/profile')}}"><i class="fa fa-vcard-o"></i>  @lang('core.m_profile')</a></li>
                        <li class="divider"></li>
                        <li><a href="javascript://ajax" class="switch-theme" code="light-theme.css"> Light Theme </a></li>
                        <li><a href="javascript://ajax" class="switch-theme" code="blue-theme.css"> Blue Theme </a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('user/logout')}}"><i class="fa fa-power-off"></i> @lang('core.m_logout')</a></li>
                    </ul>
                </div>
            </div>    


        </li>      
        @foreach ($sidebar as $menu)
            

             <li @if(Request::segment(1) == $menu['modulo']) class="active" @endif>

            @if($menu['modulo'] =='separator')
            <li class="separator"> <span> {{$menu['menu_nombre']}} </span></li>
                
            @else
                <a data-toggle="tooltip" title="{{  $menu['menu_nombre'] }}" data-placement="right"
                    @if($menu['menu_tipo'] =='external')
                        href="{{ $menu['url'] }}" 
                    @else
                        href="{{ URL::to($menu['modulo'])}}"
                    @endif              
                
                 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
                    <i class="{{$menu['menu_iconos']}}"></i>
                    <span class="nav-label">                    
                        {{ (isset($menu['menu_lang']['title'][session('lang')]) ? $menu['menu_lang']['title'][session('lang')] : $menu['menu_nombre']) }}
                    </span> 
                    @if(count($menu['childs']))<span class="fa arrow"></span> @endif    
                </a> 
                @endif  
                @if(count($menu['childs']) > 0)
                    <ul class="nav nav-second-level">
                        @foreach ($menu['childs'] as $menu2)
                         <li @if(Request::segment(1) == $menu2['modulo']) class="active" @endif>
                            <a  
                                @if($menu2['menu_tipo'] =='external')
                                    href="{{ $menu2['url']}}" 
                                @else
                                    href="{{ URL::to($menu2['modulo'])}}"
                                @endif                                  
                            >
                            
                            <i class="{{$menu2['menu_iconos']}}"></i>
                           {{ (isset($menu2['menu_lang']['title'][session('lang')]) ? $menu2['menu_lang']['title'][session('lang')] : $menu2['menu_nombre']) }}
                            </a> 
                            @if(count($menu2['childs']) > 0)
                            <ul class="nav nav-third-level">
                                @foreach($menu2['childs'] as $menu3)
                                    <li @if(Request::segment(1) == $menu3['modulo']) class="active" @endif>
                                        <a 
                                            @if($menu['menu_tipo'] =='external')
                                                href="{{ $menu3['url'] }}" 
                                            @else
                                                href="{{ URL::to($menu3['modulo'])}}"
                                            @endif                                      
                                        
                                        >
                                       
                                        <i class="{{$menu3['menu_iconos']}}"></i>
                                        {{ (isset($menu3['menu_lang']['title'][session('lang')]) ? $menu3['menu_lang']['title'][session('lang')] : $menu3['menu_nombre']) }}
                                            
                                        </a>
                                    </li>   
                                @endforeach
                            </ul>
                            @endif                          
                        </li>                           
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

    </ul>   
    </nav>
    </div>
</div>