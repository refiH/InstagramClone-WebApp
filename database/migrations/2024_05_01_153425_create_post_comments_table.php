<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('post_comments', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->longText('content');
      $table->timestamps();

      // RELATIONS
      $table->foreignUuid('post_id')->references('id')->on('posts');
      $table->foreignUuid('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('post_comments');
  }
};
