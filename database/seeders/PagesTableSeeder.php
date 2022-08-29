<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //page
        Page::create([
            'title'         =>  'Root',
            'content'       =>  'This is the root page, don\'t delete this one',
            'parent_id'     =>  null,
            'slug'          => 'root'
        ]);
    }
}
