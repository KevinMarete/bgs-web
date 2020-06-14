<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddNewSellerPackages extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::disableForeignKeyConstraints();
    DB::table('tbl_package')->truncate();
    Schema::enableForeignKeyConstraints();

    DB::table('tbl_package')->insert(
      [
        ['name' => 'Free', 'price' => '0', 'created_at' => now(), 'details' => json_encode([
          'published_items' => ['value' => '5', 'description' => '5 products published'],
          'cash_orders' => ['value' => true, 'description' => 'Get cash orders from chemists & institutions'],
          'product_visiblity' => ['value' => '0', 'description' => 'No product visibility in the first page'],
          'offer_of_day' => ['value' => '0', 'description' => 'No products in the offers of the day window'],
          'graphic_design' => ['value' => false, 'description' => 'No free graphic design for items in the promotion window'],
          'promotions' => ['value' => '1', 'description' => '0% Discount on Promotions'],
        ])],
        ['name' => 'Bronze', 'price' => '2499', 'created_at' => now(), 'details' => json_encode([
          'published_items' => ['value' => '20', 'description' => '20 products published'],
          'cash_orders' => ['value' => true, 'description' => 'Get cash orders from chemists & institutions'],
          'product_visiblity' => ['value' => '1', 'description' => '1 product visibility in the first page'],
          'offer_of_day' => ['value' => '0', 'description' => 'No products in the offers of the day window'],
          'graphic_design' => ['value' => false, 'description' => 'No free graphic design for items in the promotion window'],
          'promotions' => ['value' => '1', 'description' => '0% Discount on Promotions'],
        ])],
        ['name' => 'Silver', 'price' => '4499', 'created_at' => now(), 'details' => json_encode([
          'published_items' => ['value' => '30', 'description' => '30 products published'],
          'cash_orders' => ['value' => true, 'description' => 'Get cash orders from chemists & institutions'],
          'product_visiblity' => ['value' => '2', 'description' => '2 product visibility in the first page'],
          'offer_of_day' => ['value' => '2', 'description' => '2 products in the offers of the day window'],
          'graphic_design' => ['value' => false, 'description' => 'No free graphic design for items in the promotion window'],
          'promotions' => ['value' => '1', 'description' => '0% Discount on Promotions'],
        ])],
        ['name' => 'Gold', 'price' => '9999', 'created_at' => now(), 'details' => json_encode([
          'published_items' => ['value' => '50', 'description' => '50 products published'],
          'cash_orders' => ['value' => true, 'description' => 'Get cash orders from chemists & institutions'],
          'product_visiblity' => ['value' => '5', 'description' => '5 product visibility in the first page'],
          'offer_of_day' => ['value' => '5', 'description' => '5 products in the offers of the day window'],
          'graphic_design' => ['value' => false, 'description' => 'No free graphic design for items in the promotion window'],
          'promotions' => ['value' => '1', 'description' => '0% Discount on Promotions'],
        ])],
        ['name' => 'Platinum', 'price' => '14999', 'created_at' => now(), 'details' => json_encode([
          'published_items' => ['value' => '100000', 'description' => 'Unlimited products published'],
          'cash_orders' => ['value' => true, 'description' => 'Get cash orders from chemists & institutions'],
          'product_visiblity' => ['value' => '10', 'description' => '10 product visibility in the first page'],
          'offer_of_day' => ['value' => '10', 'description' => '10 products in the offers of the day window'],
          'graphic_design' => ['value' => true, 'description' => 'Free graphic design for items in the promotion window'],
          'promotions' => ['value' => '0.9', 'description' => '10% Discount on Promotions'],
        ])]
      ]
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::disableForeignKeyConstraints();
    DB::table('tbl_package')->truncate();
    Schema::enableForeignKeyConstraints();

    DB::table('tbl_package')->insert(
      [
        ['name' => 'Basic', 'price' => '1000', 'created_at' => now(), 'details' => json_encode(["Limited access to promos & deals", "Limited access to sellers", "Email support", "Help center access"])],
        ['name' => 'Professional', 'price' => '3000', 'created_at' => now(), 'details' => json_encode(["Medium access to promos & deals", "Medium access to sellers", "Priority email support", "Help center access"])],
        ['name' => 'Enterprise', 'price' => '5000', 'created_at' => now(), 'details' => json_encode(["All access to promos & deals", "All access to sellers", "Phone and email support", "Help center access"])],
      ]
    );
  }
}
