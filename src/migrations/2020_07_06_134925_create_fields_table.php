<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('av_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('route')->nullable();
            $table->string('model')->nullable();
            $table->boolean('create_model')->default(1);
            $table->boolean('create_migration')->default(1);
            $table->boolean('create_controller')->default(1);
            $table->boolean('create_views')->default(1);
            $table->boolean('create_permissions')->default(0);
            $table->timestamps();
        });

        Schema::create('av_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('class')->nullable();
            $table->timestamps();
        });

        Schema::create('av_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_id')->nullable();
            $table->unsignedBigInteger('type_id')->default(1);
            $table->unsignedSmallInteger('length')->nullable();
            $table->string('name');
            $table->string('title');
            $table->boolean('nullable')->default(1);
            $table->string('default')->nullable();
            $table->boolean('fillable')->default(1);
            $table->boolean('inlist')->default(1);
            $table->text('settings')->nullable();
            $table->timestamps();

            $table->foreign('table_id')
                ->references('id')->on('av_tables')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')->on('av_types')
                ->onDelete('cascade');
        });

        Schema::create('av_table_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_id')->nullable();
            $table->string('name');
            $table->string('uri')->nullable();
            $table->timestamps();

            $table->foreign('table_id')
                ->references('id')->on('av_tables')
                ->onDelete('cascade');
        });

        Schema::create('av_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_id')->nullable();
            $table->unsignedBigInteger('to_field')->nullable();
            $table->enum('type', ['belongsTo', 'belongsToMany', 'hasOne', 'hasMany']);
            $table->string('table')->nullable();
            $table->string('foreign_key')->nullable();

            $table->foreign('field_id')
                ->references('id')->on('av_fields')
                ->onDelete('set null');

            $table->foreign('to_field')
                ->references('id')->on('av_fields')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_table_files');
        Schema::dropIfExists('av_fields');
        Schema::dropIfExists('av_types');
        Schema::dropIfExists('av_tables');
    }
}
