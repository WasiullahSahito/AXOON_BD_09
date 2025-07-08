<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
    'image_path'  => 'banners/banner_img_01.jpg', // Ensure this image exists in storage/app/public/banners
    'title'       => 'Zay eCommerce',
    'subtitle'    => 'Tiny and Perfect eCommerce Template',
    'description' => 'Zay Shop is an eCommerce HTML CSS template with Bootstrap 5 Alpha 2 HTML CSS layout. This template is best suitable for your online shop or store. You can get this for absolutely free.',
    'link_url'    => '/products',
    'order'       => 1,
    'is_active'   => true,
]);

Banner::create([
    'image_path'  => 'banners/banner_img_02.jpg',
    'title'       => 'Proident ac Kosher',
    'subtitle'    => 'Aliquip excepteur et minim reprehenderit',
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'link_url'    => '/products',
    'order'       => 2,
    'is_active'   => true,
]);

Banner::create([
    'image_path'  => 'banners/banner_img_03.jpg',
    'title'       => 'Adipiscing elit, sed do',
    'subtitle'    => 'Excepteur sint occaecat cupidatat non proident',
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'link_url'    => '/products',
    'order'       => 3,
    'is_active'   => true,
]);

    }
}
