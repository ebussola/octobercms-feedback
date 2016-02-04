<?php namespace eBussola\Feedback\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BugfixChannelsTable extends Migration
{

    public function up()
    {
        Schema::table('ebussola_feedback_channels', function(Blueprint $table)
        {
            $table->longText('method_data')->change();
        });
    }

    public function down()
    {
        Schema::table('ebussola_feedback_channels', function(Blueprint $table)
        {
            $table->string('method_data')->change();
        });
    }

}
