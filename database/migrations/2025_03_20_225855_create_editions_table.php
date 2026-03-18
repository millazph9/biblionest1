<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l'édition (ex: "3ème édition révisée")
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Lien vers un livre
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('editions');
    }
};
