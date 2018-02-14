<div class="row  ">
    <nav style="margin-bottom: 0;" role="navigation" class="navbar navbar-fixed-top ">
    <div class="navbar-header">
         <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn  ">
            <i class="fa fa-bars"></i> 
         </a>    
             
    </div>

     <ul class="nav navbar-top-links navbar-right">

        @if(config('ktn.cnf_multilang') ==1)
        <li class="dropdown tasks-menu">
          <?php 
          $flag ='en';
          $langname = 'English'; 
          foreach(SiteHelpers::langOption() as $lang):
            if($lang['folder'] == session('lang') or $lang['folder'] == config('ktn.cnf_lang')) {
              $flag = $lang['folder'];
              $langname = $lang['name']; 
            }
            
          endforeach;?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <img class="flag-lang" src="{{ asset('katana/images/flags/'.$flag.'.png') }}" width="16" height="12" alt="lang" /> {{ strtoupper($flag) }}
            <span class="hidden-xs">
            
            </span>
          </a>

           <ul class="dropdown-menu dropdown-menu-right icons-right">
            @foreach(SiteHelpers::langOption() as $lang)
              <li><a href="{{ url('home/lang/'.$lang['folder'])}}"><img class="flag-lang" src="{{ asset('katana/images/flags/'. $lang['folder'].'.png')}}" width="16" height="11" alt="lang"  /> {{  $lang['name'] }}</a></li>
            @endforeach 
          </ul>

        </li> 
        @endif 

        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="pe-7s-bell icons-pe"></i>
              <span class="label label-green notif-alert">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"> </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="notification-menu">
                  
                </ul>  
              <li><a href="{{ url('notification')}}">View all</a></li>
            </ul>
          </li>
     
        <li class="dropdown user">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <i class="pe-7s-tools icons-pe"></i>  
            </a>
            <ul class="dropdown-menu navbar-mega-menu animated flipInX" style="display: none;">

     @if(Auth::user()->grupo_id == 1 or Auth::user()->grupo_id ==2 )
    <li class="col-sm-3">
        <ul>
            <li class="dropdown-header">  @lang('core.m_setting') </li>
            <li class="divider"></li>
             <li><a href="{{ url('') }}/katana/config"><i class="fa fa-sliders"></i> @lang('core.t_generalsetting') </a> </li>
             <li><a href="{{ url('') }}/katana/config/email"><i class="fa fa-envelope"></i>@lang('core.t_emailtemplate') </a> </li>
             <li><a href="{{ url('') }}/katana/config/security"><i class="fa fa-lock"></i>  @lang('core.t_loginsecurity') </a> </li>
             <li><a href="{{ url('') }}/katana/config/translation"><i class="fa fa-map"></i> @lang('core.tab_translation') </a> </li>

           
        </ul>
    </li>
                                
    <li class="col-sm-3">
        <ul>
            <li class="dropdown-header"> Administrator </li>
            <li class="divider"></li>
            <li ><a href="{{ url('core/usuarios')}}"> <i class="fa fa-user-circle-o"></i> @lang('core.m_users') <br /></a> </li> 
            <li ><a href="{{ url('core/grupos')}}"> <i class="fa fa-user-plus"></i> @lang('core.m_groups') </a> </li>
             
        </ul>
    </li>
    @endif
     @if(Auth::user()->grupo_id == 1  )
    <li class="col-sm-3">
        <ul>
            <li class="dropdown-header"> Super Admin</li>
             <li class="divider"></li>       
               <li><a href="{{ url('katana/modulo')}}"><i class="fa fa-free-code-camp"></i> @lang('core.m_codebuilder')  </a> </li>

 

            
        </ul>
    </li> 
    <li class="col-sm-3">
        <ul>
            <li class="dropdown-header"> Herramientas </li>
            <li class="divider"></li>
                <li><a href="{{ url('katana/menu')}}"><i class="fa fa-sitemap"></i>  @lang('core.m_menu')</a> </li>              

 
        </ul>
    </li>
    @endif    
                             


            </ul>
        </li>
        <li><a href="{{ url('/logout')}}"><i class="pe-7s-angle-right-circle icons-pe"></i> </a></li>
    </ul>   
    </nav>   
     


</div>  