<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        @yield("meta")
        <title>
        SIPEC
        </title>
        <link href="{{ asset('assets/css/style.default.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/js/jqueryui/jquery.alerts.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/css/select2.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/css/sweetalert.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/css/jquery.gritter.css')}}" rel="stylesheet">

          @yield('css')
    </head>

    <body>
        
        <header>
            <div class="headerwrapper">
                <div class="header-left">
                    <a href="#" style="color: white; font-size: 20px;"class="logo">
                        <i class="fa fa-graduation-cap"></i> SIPEC
                    </a>
                    <div class="pull-right">
                        <a href="#" class="menu-collapse">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </div><!-- header-left -->
                
                <div class="header-right">
                        <span style="margin-bottom: 0px; color: white; font-size: 20px;">
                        Sistema de Informacion para Partticipantes de la Unidad de Educación Continua
                        </span>

                    <div class="pull-right">  
                        <div class="btn-group btn-group-option">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#"><i class="glyphicon glyphicon-user"></i>Perfil</a></li>
                              <li class="divider"></li>
                              @if(Auth::check())
                              <li><a href="{{ URL::to('salir') }}"><i class="glyphicon glyphicon-log-out"></i>Cerrar Sesión</a></li>
                              @else
                            <li><a href="{{ route('logout.part') }}"><i class="glyphicon glyphicon-log-out"></i>Cerrar Sesión</a></li>
                              @endif
                            </ul>
                        </div><!-- btn-group -->
                        
                    </div><!-- pull-right -->
                    
                </div><!-- header-right -->
                
            </div><!-- headerwrapper -->
        </header>
        
        <section>
            <div class="mainwrapper">
                <div class="leftpanel">
                    <div class="media profile-left">
                    @if(Auth::check())
                    <a class="pull-left profile-thumb" href="/usuarios/perfil/{{Auth::user()->id}}">
                    @else
                    <a class="pull-left profile-thumb" href="#">
                    @endif
                    <div class="img-circle"  id="profileImage"></div>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">
                            @if(Auth::check())
                            <?php 
                            $nombres = explode(" ", Auth::user()->nombre); 
                            $apellidos = explode(" ", Auth::user()->apellidos);
                            ?>

                                    <span id="firstName">{!! $nombres[0] !!} <span id="lastName">{!! $apellidos[0] !!}</span>
                            
                            </h4>
                            <small class="text-muted">Ultima sesión: {!!date("d/m/Y - H:m:s", strtotime(Auth::user()->updated_at)) !!}</small>
                            @else
                                <?php   
                                        if(Session::has('nombres')){
                                            $nombres = explode(" ", Session::get('nombres')); 
                                        }
                                        if(Session::has('apellidos')){
                                            $apellidos = explode(" ", Session::get('apellidos'));
                                        }                            
                                        ?>
                                        @if(Session::has('nombres'))
                                        <span id="firstName">{!! $nombres[0] !!} <span id="lastName">{!! $apellidos[0] !!}</span>
                                        @endif
                            
                            </h4>
                            @endif
                        </div>
                    </div><!-- media -->
                    <h5 class="leftpanel-title">Menú Principal</h5>
                    <ul class="nav nav-pills nav-stacked">
                         @if(Auth::check())
                        <li {{ (Request::is('/') ? ' class=active' : '') }}><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i> <span>Principal</span></a></li>
                        @foreach(Auth::user()->modulos as $modulo)
                                @if($modulo->id_arbol == 0 AND $modulo->menu == TRUE)
                                   @if(Request::is($modulo->ruta.'*'))
                                    <li class="parent active"><a href="{{ URL::to('#') }}"><i class="{{ $modulo->icon_class}}"></i> <span>{!! $modulo->nombre !!}</span></a>
                                   @else
                                   <li class="parent"><a href="{{ URL::to('#') }}"><i class="{{ $modulo->icon_class}}"></i> <span>{!! $modulo->nombre !!}</span></a>
                                   @endif
                                @elseif($modulo->id_arbol != 0 AND $modulo->menu == TRUE)
                                    @if(Request::is($modulo->ruta.'*'))
                                    <ul class="children">
                                                <li class="active"><a href="{{ url($modulo->ruta) }}"><i class="{{ $modulo->icon_class}}"></i> {!! $modulo->nombre !!}</a></li> 
                                            </ul>
                                    @else
                                    <ul class="children">
                                                <li><a href="{{ url($modulo->ruta) }}"><i class="{{ $modulo->icon_class}}"></i> {!! $modulo->nombre !!}</a></li> 
                                            </ul>
                                    @endif
                                @endif
                        @endforeach
                        @else
                        <li {{ (Request::is('participante') ? ' class=active' : '') }}><a href="{{ URL::to('#') }}"><i class="fa fa-home"></i> <span>Principal</span></a>
                            @if(Request::is('participante/actacademica*'))
                                <li class="parent active"><a href="{{ URL::to('#') }}"><i class="fa fa-graduation-cap"></i> <span>Actuación Académica</span></a>
                            @else
                                <li class="parent"><a href="#"><i class="fa fa-graduation-cap"></i> <span>Actuación Académica</span></a>
                             @endif
                             @if(Request::is('participante/actacademica'))
                               <ul class="children">
                                                <li class="active"><a href="{{ route('actacademica') }}"><i class="fa fa-edit"></i> Recor Académico</a></li> 
                                            </ul>
                            @else
                                <ul class="children">
                                                <li><a href="{{ route('actacademica') }}"><i class="fa fa-edit"></i> Recor Académico</a></li> 
                                            </ul>
                             @endif
                        @endif

                    </ul>
                </div><!-- leftpanel -->
                
                <div class="mainpanel">
                    <div class="pageheader">
                        <h4>@yield('modulo')</h4> 
                    </div><!-- pageheader -->
                    <div class="contentpanel" id="imprimir">
                      @yield('contenido')
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>



         <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
         <script src="{{asset('assets/js/jqueryui/jquery.ui.draggable.js')}}"></script>
         <script src="{{asset('assets/js/jqueryui/jquery.alerts.js')}}"></script>
        <script src="{{asset('assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('assets/js/pace.min.js')}}"></script>
        <script src="{{asset('assets/js/retina.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.cookies.js')}}"></script>
        {!! HTML::script('assets/js/select2.min.js')!!}
        {!! HTML::script('assets/js/sweetalert.min.js')!!}
         {!! HTML::script('assets/js/jquery.gritter.min.js')!!}

        <script src="{{asset('assets/js/custom.js')}}"></script>

          @yield('scripts')

          <script type="text/javascript">
            $(document).ready(function(){
                      var firstName = $('#firstName').text();
                      var lastName = $('#lastName').text();
                      var intials = $('#firstName').text().charAt(0) + $('#lastName').text().charAt(0);
                      var profileImage = $('#profileImage').text(intials);
                    });
          </script>


    </body>
</html>