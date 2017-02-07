<?php

namespace sipec\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \sipec\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \sipec\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \sipec\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \sipec\Http\Middleware\RedirectIfAuthenticated::class,
        'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,
        'modulo' => \sipec\Http\Middleware\PermisoModulo::class,
        'ver' => \sipec\Http\Middleware\VerModulo::class,
        'buscar' => \sipec\Http\Middleware\BuscarModulo::class,
        'incluir' => \sipec\Http\Middleware\IncluirModulo::class,
        'modificar' => \sipec\Http\Middleware\ModificarModulo::class,
        'eliminar' => \sipec\Http\Middleware\EliminarModulo::class,
        'procesar' => \sipec\Http\Middleware\ProcesarModulo::class,
        'imprimir' => \sipec\Http\Middleware\ImprimirModulo::class,
        'anular' => \sipec\Http\Middleware\AnularModulo::class,



    ];
}
