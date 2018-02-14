<ul class="nav nav-tabs" style="margin-bottom:30px;">
  <li><a href="{{ url('katana/modulo')}}"> Todo </a></li>
  <li @if($active == 'config') class="active" @endif ><a href="{{ URL::to('katana/modulo/config/'.$modulo_nombre)}}"> Información</a></li>
  <li @if($active == 'sql') class="active" @endif >
  @if(isset($type) && $type =='blank')

  @else
  <a href="{{ URL::to('katana/modulo/sql/'.$modulo_nombre)}}"> SQL</a></li>
  <li @if($active == 'table') class="active" @endif >
  <a href="{{ URL::to('katana/modulo/table/'.$modulo_nombre)}}"> Tabla</a></li>
  <li @if($active == 'form' or $active == 'subform') class="active" @endif >
  <a href="{{ URL::to('katana/modulo/form/'.$modulo_nombre)}}"> Formulario</a></li>
  {{--<li @if($active == 'sub'  ) class="active" @endif >--}}
  {{--<a href="{{ URL::to('katana/modulo/sub/'.$modulo_nombre)}}"> Maestro Detalle</a></li>--}}
  @endif
  <li @if($active == 'permission') class="active" @endif >
  <a href="{{ URL::to('katana/modulo/permission/'.$modulo_nombre)}}"> Permisos</a></li>
  @if($type !='core' )
  {{--<li @if($active == 'source') class="active" @endif >--}}
  {{--<a href="{{ URL::to('katana/modulo/source/'.$modulo_nombre)}}"> Códigos </a></li>--}}
  @endif

  
   <li @if($active == 'rebuild') class="active" @endif >

    @if(isset($type) && ( $type =='blank' or $type =='core'))

    @else
    <a href="javascript://ajax" onclick="SximoModal('{{ URL::to('katana/modulo/build/'.$modulo_nombre)}}','Recontruir Módulo ')"> Reconstruir</a></li>
   @endif
    <li class="dropdown pull-right">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Más </a>
    <ul class="dropdown-menu">
      <?php $md = DB::table('tb_modulo')->where('modulo_type','!=','core')->get();
      foreach($md as $m) { ?>
      <li><a href="{{ url('katana/modulo/'.$active.'/'.$m->modulo_nombre)}}"> {{ $m->modulo_titulo}}</a></li>
      <?php } ?>
    </ul>
  </li>

  
  
</ul>