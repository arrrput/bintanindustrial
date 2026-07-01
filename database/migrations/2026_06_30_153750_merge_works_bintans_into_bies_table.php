<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tambah kolom baru ke bies (additive, tidak hapus apapun dulu)
        Schema::table('bies', function (Blueprint $table) {
            if (!Schema::hasColumn('bies', 'page_group')) {
                $table->string('page_group')->default('bie')->after('id');
            }
            if (!Schema::hasColumn('bies', 'layout_style')) {
                $table->string('layout_style')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('bies', 'extra_content')) {
                $table->json('extra_content')->nullable()->after('layout_style');
            }
        });

        // 2. Ubah category dari enum ke string dan description jadi nullable
        DB::statement('ALTER TABLE bies MODIFY COLUMN category VARCHAR(50) NULL');
        DB::statement('ALTER TABLE bies MODIFY COLUMN description TEXT NULL');

        // 3. Tandai semua data bies lama sebagai page_group = 'bie'
        DB::table('bies')->update(['page_group' => 'bie']);

        // 4. Pindahkan data works ke bies (skip jika tabel sudah tidak ada)
        if (Schema::hasTable('works')) {
            foreach (DB::table('works')->get() as $work) {
                DB::table('bies')->insert([
                    'page_group'   => 'work',
                    'badge'        => null,
                    'title'        => $work->title,
                    'subtitle'     => $work->subtitle,
                    'description'  => $work->description,
                    'image'        => $work->image,
                    'icon'         => $work->icon,
                    'layout_style' => null,
                    'extra_content'=> null,
                    'category'     => $work->category,
                    'order'        => $work->order,
                    'created_at'   => $work->created_at,
                    'updated_at'   => $work->updated_at,
                ]);
            }
        }

        // 5. Pindahkan data bintans ke bies (skip jika tabel sudah tidak ada)
        if (Schema::hasTable('bintans')) {
            foreach (DB::table('bintans')->get() as $bintan) {
                DB::table('bies')->insert([
                    'page_group'   => 'bintan',
                    'badge'        => $bintan->badge,
                    'title'        => $bintan->title,
                    'subtitle'     => $bintan->subtitle,
                    'description'  => $bintan->description,
                    'image'        => $bintan->image,
                    'icon'         => $bintan->icon,
                    'layout_style' => $bintan->layout_style,
                    'extra_content'=> $bintan->extra_content,
                    'category'     => $bintan->category,
                    'order'        => $bintan->order,
                    'created_at'   => $bintan->created_at,
                    'updated_at'   => $bintan->updated_at,
                ]);
            }
        }

        // 6. Hapus tabel lama setelah data berhasil dipindah
        Schema::dropIfExists('works');
        Schema::dropIfExists('bintans');
    }

    public function down()
    {
        // Recreate works table
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('category')->default('main_section');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Recreate bintans table
        Schema::create('bintans', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('layout_style')->default('default');
            $table->json('extra_content')->nullable();
            $table->string('category')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Kembalikan data works
        DB::table('bies')->where('page_group', 'work')->get()->each(function ($item) {
            DB::table('works')->insert([
                'title'       => $item->title,
                'subtitle'    => $item->subtitle,
                'description' => $item->description,
                'image'       => $item->image,
                'icon'        => $item->icon,
                'category'    => $item->category,
                'order'       => $item->order,
                'created_at'  => $item->created_at,
                'updated_at'  => $item->updated_at,
            ]);
        });

        // Kembalikan data bintans
        DB::table('bies')->where('page_group', 'bintan')->get()->each(function ($item) {
            DB::table('bintans')->insert([
                'badge'        => $item->badge,
                'title'        => $item->title,
                'subtitle'     => $item->subtitle,
                'description'  => $item->description,
                'image'        => $item->image,
                'icon'         => $item->icon,
                'layout_style' => $item->layout_style,
                'extra_content'=> $item->extra_content,
                'category'     => $item->category,
                'order'        => $item->order,
                'created_at'   => $item->created_at,
                'updated_at'   => $item->updated_at,
            ]);
        });

        // Hapus data works dan bintan dari bies
        DB::table('bies')->whereIn('page_group', ['work', 'bintan'])->delete();

        // Hapus kolom yang ditambahkan
        Schema::table('bies', function (Blueprint $table) {
            $table->dropColumn(['page_group', 'layout_style', 'extra_content']);
        });

        // Kembalikan category ke semula
        DB::statement("ALTER TABLE bies MODIFY COLUMN category VARCHAR(50) NULL");
    }
};
