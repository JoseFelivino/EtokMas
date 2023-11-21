<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(roleseeder::class);
        $this->call(categoriesseeder::class);
        $this->call(gold_carat_categoriesseeder::class);
        $this->call(shelvesseeder::class);
        $this->call(customersseeder::class);
        $this->call(pawn_transaction_statusesseeder::class);
        $this->call(usersseeder::class);
        $this->call(transaction_headersseeder::class);
        $this->call(pawn_transaction_headersseeder::class);
        $this->call(goldseeder::class);
        $this->call(transaction_detailsseeder::class);
        $this->call(stocksseeder::class);
        $this->call(gold_categoriesseeder::class);
        $this->call(book_keeping_headersseeder::class);
        $this->call(book_keeping_detailsseeder::class);
        $this->call(NotificationSeeder::class);
        
    }
}
