<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
            'name' => 'ไก่',
            'type' => 'material',
            'price' => '55',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'ปลาแซลม่อน',
            'type' => 'material',
            'price' => '75',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'ปลาดอลลี่',
            'type' => 'material',
            'price' => '75',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'ปลากะพง',
            'type' => 'material',
            'price' => '95',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'กุ้ง',
            'type' => 'material',
            'price' => '129',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'ลูกชิ้นปลา',
            'type' => 'material',
            'price' => '79',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'เห็ด',
            'type' => 'material',
            'price' => '55',
        ])->menus()->attach(\App\Menu::all());
        \App\Product::create([
            'name' => 'ข้าวผัดน้ำพริกกุ้งเฉียบ',
            'type' => 'exclusive',
            'price' => '75',
        ]);
        \App\Product::create([
            'name' => 'ไข่ตุ๋น',
            'type' => 'exclusive',
            'price' => '55',
        ]);
        \App\Product::create([
            'name' => 'แซนวิชไก่',
            'type' => 'exclusive',
            'price' => '49',
        ]);
        \App\Product::create([
            'name' => 'แซนวิชแซลม่อน',
            'type' => 'exclusive',
            'price' => '69',
        ]);
        \App\Product::create([
            'name' => 'แซนวิชทูน่า',
            'type' => 'exclusive',
            'price' => '69',
        ]);
        \App\Product::create([
            'name' => 'ข้าวต้มไก่',
            'type' => 'exclusive',
            'price' => '65',
        ]);
        \App\Product::create([
            'name' => 'ก๋วยเตี๋ยวไก่น้ำ',
            'type' => 'exclusive',
            'price' => '55',
        ]);
        \App\Product::create([
            'name' => 'ก๋วยเตี๋ยวไก่แห้ง',
            'type' => 'exclusive',
            'price' => '55',
        ]);

    }
}
