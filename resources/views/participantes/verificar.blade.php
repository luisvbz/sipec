<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Verificar</title>

        <link href="{!! asset('assets/css/style.default.css') !!}" rel="stylesheet">

    </head>

    <body class="signin">
        <section>
            
            <div class="panel panel-signin">
                <div class="panel-body">
                    <div class="logo text-center">
                    <center><span style="font-size: 60px;"><i class="fa fa-graduation-cap"></i></span></center>
                    <center><h3>SIPEC</h3></center>
                    </div>
                    
                    <div class="mb30"></div>
                    {!! Form::open(array('route' => 'verificar.participante', 'method' => 'post', 'id' => 'verficar')) !!}
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                         {!! Form::text('cedula',null, array('class' => 'form-control', 'placeholder' => 'Cedula' , 'id' => 'cedula', 'style' => 'padding: 12px;')) !!}
                    </div>
                    <div class="clearfix">
                        
                           {!! Form::submit('Soy participante, Verificame!', array('class' => 'btn btn-success btn-block-level')) !!} 
                        
                    </div>   
                    {!! Form::close() !!}
                    <br>
                        @if (Session::has('message'))
                            <div class="alert alert-danger">{!! Session::get('message') !!} <i class="fa fa-times-circle"></i></div>
                        @endif
                </div><!-- panel-body -->
            </div><!-- panel -->
        </section>

        <script src="{!! asset('assets/js/jquery-1.11.1.min.js') !!}"></script>
        <script src="{!! asset('assets/js/jquery-migrate-1.2.1.min.js') !!}"></script>
        <script src="{!! asset('assets/js/bootstrap.min.js') !!}"></script>
        <script src="{!! asset('assets/js/modernizr.min.js') !!}"></script>
        <script src="{!! asset('assets/js/pace.min.js') !!}"></script>
        <script src="{!! asset('assets/js/retina.min.js') !!}"></script>
        <script src="{!! asset('assets/js/jquery.cookies.js') !!}"></script>
        <script src="{!! asset('assets/js/custom.js') !!}"></script>
        <script src="{!! asset('assets/js/jquery.validate.min.js') !!}"></script>

        <script type="text/javascript">
            $('#login').validate({
                rules: {
                    'cedula': {
                        number : true,
                        required: true
                    },
                    'password': 'required'
                },
                messages: {
                    'cedula': {
                     number : 'La cedula solo puede contener numeros',
                     required: 'Debe ingresar la cedula'   
                    },
                    'password': 'Debe ingresar la clave'
                },
                highlight: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    success: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-error');
                    }
            });
        </script>


    </body>
</html>
