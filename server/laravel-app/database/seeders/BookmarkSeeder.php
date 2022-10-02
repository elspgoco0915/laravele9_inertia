<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('bookmarks')->insert([
            [
                'title' => 'title',
                'url'   => 'https://blog.shipweb.jp/',
            ],
            [
                'title' => 'title2',
                'url'   => 'https://google.co.jp/',
            ],
        ]);
    }
}
