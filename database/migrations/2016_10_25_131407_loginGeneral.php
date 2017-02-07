<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoginGeneral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistemas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('cod_sistema');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });


        Schema::create('modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('cod_sistema');
            $table->string('descripcion')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('ruta')->nullable();
            $table->integer('sistema_id');
            $table->timestamps();
        });

        Schema::create('modulos_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('modulo_id')->unsigned();
            $table->boolean('pantalla');
            $table->boolean('buscar');
            $table->boolean('incluir');
            $table->boolean('modificar');
            $table->boolean('eliminar');
            $table->boolean('procesar');
            $table->boolean('imprimir');
            $table->boolean('anular');


            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('modulo_id')->references('id')->on('modulos')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'modulo_id']);
        });

         Schema::create('sedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod_sede')->unique();
            $table->string('denominacion');
            $table->string('abrev')->nullable();
            $table->timestamps();
        });

         Schema::create('sede_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('sede_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sede_id')->references('id')->on('sedes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'sedes_id']);
        });


         Schema::create('autoridades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('cargo');
            $table->boolean('activo');
            $table->timestamps();
        });

         Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
       

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistemas');
        Schema::drop('modulos');
        Schema::drop('modulo_user');
        Schema::drop('sedes');
        Schema::drop('sede_user');
        Schema::drop('autoridades');
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
