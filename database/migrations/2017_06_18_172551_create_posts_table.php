<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function (Blueprint $table) {
			//@TODO: Permissions

			$table->increments('id');
			$table->string('slug')->nullable()->index();
			$table->string('type')->index();
			$table->string('title')->index();
			$table->string('title2');
			$table->string('locale', 2)->default('fa')->index();
			$table->float('price', 15, 2);
			$table->float('sale_price', 15, 2)->default(0);
			$table->timestamp('sale_starts_at')->nullable();
			$table->timestamp('sale_expires_at')->nullable();
			$table->boolean('is_available')->default(1);
			$table->boolean('is_draft')->default(1);
			$table->boolean('is_limited')->default(0);
			$table->unsignedInteger('copy_of')->default(0)->index();
			$table->string('sisterhood', 30)->default('')->index();

			$table->longText('text')->nullable();
			$table->longText('abstract')->nullable();

			$table->timestamp('starts_at')->nullable();
			$table->timestamp('ends_at')->nullable();

			$table->longText('meta')->nullable();

			$table->integer('seo_score')->default(-1);
			$table->timestamp('pinned_at')->nullable()->index();
			$table->unsignedInteger('pinned_by')->default(0);

			$table->string('domains', '200')->nullable();

			$table->timestamps();
			$table->softDeletes();
			$table->timestamp('published_at')->nullable();
			$table->unsignedInteger('created_by')->default(0)->index();
			$table->unsignedInteger('updated_by')->default(0);
			$table->unsignedInteger('deleted_by')->default(0);
			$table->unsignedInteger('published_by')->default(0);

			$table->unsignedInteger('owned_by')->default(0)->index();
			$table->unsignedInteger('moderated_by')->default(0)->index();
			$table->timestamp('moderated_at')->nullable();

			$table->index('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('posts');
	}
}
