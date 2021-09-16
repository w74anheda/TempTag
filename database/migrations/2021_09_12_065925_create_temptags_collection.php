<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemptagsCollection extends Migration
{
    protected $connection = 'mongodb';

    public function up()
    {
        Schema::connection($this->connection)
            ->table('temptags', function (Blueprint $collection) {
                $collection->index(['temptagable_id', 'temptagable_type', 'title']);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temptags');
    }
}
