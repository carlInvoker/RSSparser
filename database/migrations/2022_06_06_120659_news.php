<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

     //  0 => SimpleXMLElement {#274 ▼
     // +"title": SimpleXMLElement {#301}
     // +"link": "https://lifehacker.com/how-to-tell-if-your-child-has-binge-eating-disorder-an-1849008247"
     // +"description": SimpleXMLElement {#302}
     // +"category": array:16 [▶]
     // +"pubDate": "Mon, 06 Jun 2022 12:30:00 GMT"
     // +"guid": "1849008247"

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->string("link", 255)->nullable();
            $table->text('description');
            $table->json("category");
            $table->dateTimeTz('pubdate', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
