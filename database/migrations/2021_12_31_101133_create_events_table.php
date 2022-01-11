<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('イベント名');
            $table->dateTime('start')->comment('開始日時');
            $table->dateTime('end')->comment('終了日時');
            $table->boolean('timed')->nullable()->default(false)->comment('終日');
            $table->text('description')->nullable()->comment('イベント詳細');
            $table->string('color')->nullable()->comment('イベントカラー');
            $table->foreignId('calendar_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
