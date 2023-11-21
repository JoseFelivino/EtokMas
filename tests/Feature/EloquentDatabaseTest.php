<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Gold;
use App\Models\Stock;
use App\Models\Shelf;
use App\Models\GoldCaratCategory;
use App\Models\TransactionHeader;
use App\Models\Customer;
use App\Models\TransactionDetail;
use App\Models\PawnTransactionHeader;
use App\Models\BookKeepingHeader;
use App\Models\BookKeepingDetail;
use App\Models\Category;
use App\Models\GoldCategory;

class EloquentDatabaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_role_relationship()
    {
        $role = Role::factory()->hasUsers(3)->create();
        
        $this->assertCount(3, $role->users);
    }

    public function test_user_relationship()
    {
        $user = User::factory()->forRole()->create();
        $this->assertNotEmpty($user->role);
    }

    public function test_gold_relationship()
    {
        $gold = Gold::factory()
        ->hasStock()
        ->forShelf()
        ->forGoldCaratCategory()
        ->for(
            User::factory()->forRole()
        )
        ->has(
            Category::factory()->count(3),
            'categories' 
        )
        ->has(
            TransactionDetail::factory()
            ->for(
                TransactionHeader::factory()
                ->for(
                    User::factory()->forRole()
                )
                ->for(
                    Customer::factory()
                )
            )
            ->for(
                Gold::factory()
                ->hasStock()
                ->forShelf()
                ->forGoldCaratCategory()
                ->for(
                    User::factory()->forRole()
                )
            )->count(3)
        )
        ->has(
            BookKeepingDetail::factory()
            ->for(
                Gold::factory()
                ->hasStock()
                ->forShelf()
                ->forGoldCaratCategory()
                ->for(
                    User::factory()->forRole()
                )
            )
            ->forBookKeepingHeader()
            ->count(3)
        )
        ->create();
        $this->assertNotEmpty($gold->stock);
        $this->assertNotEmpty($gold->cart);
        $this->assertNotEmpty($gold->shelf);
        $this->assertNotEmpty($gold->goldCaratCategory);
        $this->assertNotEmpty($gold->user);
        $this->assertCount(3, $gold->categories);
        $this->assertCount(3, $gold->bookKeepingDetails);
        $this->assertCount(3, $gold->transactionDetails);
    }

    public function test_stock_relationship()
    {
        $stock = Stock::factory()
        ->for(
            Gold::factory()
            ->hasStock()
            ->forShelf()
            ->forGoldCaratCategory()
            ->for(
                User::factory()->forRole()
            )
        )
        ->create();

        $this->assertNotEmpty($stock->gold);
    }

    public function test_shelf_relationship()
    {
        $shelf = Shelf::factory()
        ->has(
            Gold::factory()
            ->hasStock()
            ->forShelf()
            ->forGoldCaratCategory()
            ->for(
                User::factory()->forRole()
            )
        )
        ->create();
        $this->assertNotEmpty($shelf->gold);
    }

    public function test_goldCaratCatagory_relationship()
    {
        $goldCaratCategory = GoldCaratCategory::factory()
        ->has(
            Gold::factory()
            ->hasStock()
            ->forShelf()
            ->forGoldCaratCategory()
            ->for(
                User::factory()->forRole()
            )
            ->count(3),
            'golds'
        )
        ->create();
        $this->assertCount(3, $goldCaratCategory->golds);
    }

    public function test_transactionHeader_relationship()
    {
        $transactionHeader = TransactionHeader::factory()
        ->for(
            User::factory()->forRole()
        )
        ->for(
            Customer::factory()
        )
        ->create();
        $this->assertNotEmpty($transactionHeader->user);
        $this->assertNotEmpty($transactionHeader->customer);
    }

    public function test_transactionDetail_relationship()
    {
        $transactionDetail = TransactionDetail::factory()
        ->for(
            TransactionHeader::factory()
            ->for(
                User::factory()->forRole()
            )
            ->for(
                Customer::factory()
            )
        )
        ->for(
            Gold::factory()
            ->hasStock()
            ->forShelf()
            ->forGoldCaratCategory()
            ->for(
                User::factory()->forRole()
            )
        )->create();
        $this->assertNotEmpty($transactionDetail->transactionHeader);
        $this->assertNotEmpty($transactionDetail->gold);
    }

    public function test_customer_relationship()
    {
        $customer = Customer::factory()
        ->has(
            PawnTransactionHeader::factory()
            ->forCustomer()
            ->for(
                User::factory()->forRole()
            )
            ->forPawnTransactionStatus()
            ->count(3)
        )
        ->has(
            TransactionHeader::factory()
            ->for(
                User::factory()->forRole()
            )
            ->for(
                Customer::factory()
            )
            ->count(3)
        )
        ->create();

        $this->assertCount(3, $customer->pawnTransactionHeaders);
        $this->assertCount(3, $customer->transactionHeaders);
    }

    public function test_pawnTransactionHeader_relationship()
    {
        $pawnTransactionHeader = PawnTransactionHeader::factory()
            ->forCustomer()
            ->for(
                User::factory()->forRole()
            )
            ->forPawnTransactionStatus()
            ->create();
        $this->assertNotEmpty($pawnTransactionHeader->pawnTransactionStatus);
    }

    public function test_bookKeepingHeader_relationship() 
    {
        $bookKeepingHeader = BookKeepingHeader::factory()
            ->has(
                BookKeepingDetail::factory()
                    ->for(
                        Gold::factory()
                        ->hasStock()
                        ->forShelf()
                        ->forGoldCaratCategory()
                        ->for(
                            User::factory()->forRole()
                        )
                    )
                    ->forBookKeepingHeader()
                    ->count(3)
            )
            ->create();

            $this->assertCount(3, $bookKeepingHeader->bookKeepingDetails);
    }

    public function test_bookKeepingDetail_relationship()
    {
        $bookKeepingDetail = BookKeepingDetail::factory()
            ->for(
                Gold::factory()
                        ->hasStock()
                        ->forShelf()
                        ->forGoldCaratCategory()
                        ->for(
                            User::factory()->forRole()
                        )
            )
            ->forBookKeepingHeader()
            ->create();

        $this->assertNotEmpty($bookKeepingDetail->bookKeepingHeader);
        $this->assertNotEmpty($bookKeepingDetail->gold);
    }

    public function test_category_relationship()
    {
        $category = Category::factory()
            ->has(
                Gold::factory()
                    ->hasStock()
                    ->forShelf()
                    ->forGoldCaratCategory()
                    ->for(
                        User::factory()->forRole()     
                    )
                    ->count(3)
                    ,
                    'golds'
                        
            )
            ->create();
        $this->assertCount(3, $category->golds);
    }
}
