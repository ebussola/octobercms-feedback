<?php namespace eBussola\Feedback\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFeedbacksTable extends Migration
{

    public function up()
    {
        Schema::create('ebussola_feedback_feedbacks', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->boolean('archived')->default(false);
            $table->integer('channel_id')->unsigned();

            $table->foreign('channel_id')
                ->references('id')
                ->on('ebussola_feedback_channels')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ebussola_feedback_feedbacks');
    }

}
