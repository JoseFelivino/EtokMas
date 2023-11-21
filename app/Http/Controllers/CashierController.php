<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stock;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\GoldCaratCategory;
use App\Models\Shelf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CashierController extends Controller
{
     /*
        Variable 
        
        Request:
        searchStockKeyword: String (nullable)
        stockCategories: [String] (nullable)
        minPrice: Int (nullable)
        maxPrice: Int (nullable)
        caratId: Int (nullable)
        shelfId: Int (nullable)
        $minWeight: float (nullable)
        $maxWeight: float (nullable)

        Response:
        allItemsInStock: [Stock]
        allGoldCaratCategory: [GoldCaratCategory]
        allCategory: [Category]
        allShelf: [Shelf]
        lowestPriceGoldValueInStock: Int
        highestPriceGoldValueInStock: Int
        lightestGoldValueInStock: float
        heaviestGoldValueInStock: float
    */
    public function index() {
        $request = request();
        $allCategory = 
        $stockSearchResult = null;  
        $searchStockKeyword = $request['searchStockKeyword'];
        $stockCategories = $request['stockCategories'];
        $minPrice = $request['minPrice'];
        $maxPrice = $request['maxPrice'];
        $caratId = $request['caratId'];
        $shelfId = $request['shelfId'];
        $minWeight = $request['minWeight'];
        $maxWeight = $request['maxWeight'];
        
        $stockSearchResult = Stock::filterByNameOrIdCategoriesPriceCaratAndWeight(
            $searchStockKeyword, 
            $stockCategories, 
            $minPrice, 
            $maxPrice, 
            $caratId,
            $shelfId,
            $minWeight,
            $maxWeight
        )
        ->orderBy('created_at', 'desc')
        ->with(
            'gold.shelf',
            'gold.goldCaratCategory',
            'gold.categories'
        )->paginate(8);
        
        return Inertia::render('Cashier/index',[
            'allItemsInStock' => $stockSearchResult,
            'allGoldCaratCategory' => GoldCaratCategory::all(),
            'allCategory' => Category::all(),
            'allShelf' => Shelf::all(),
            'lowestPriceGoldValueInStock' => Stock::getLowestPriceGoldValueInStock(),
            'highestPriceGoldValueInStock' => Stock::getHighestPriceGoldValueInStock(),
            'lightestGoldValueInStock' => Stock::getlightestGoldValueInStock(),
            'heaviestGoldValueInStock' => Stock::getHeaviestGoldValueInStock()
        ]);
    }


    /*
        Variable 
        Object: {
            stockId: String
            quantity: Int
            price: Int
        }
        Request:
        cartItems: [Object] 
        customerId: String

        Response:
    */
    public function checkout() {
        $request = request()->validate([
            'cartItems' => ['required'],
            'customerId' => ['required']
        ]);
        $cartItems = $request['cartItems'];
        $customerId = $request['customerId'];

        $loggedInUserId = Auth::id();
        self::saveTransaction($loggedInUserId, $customerId, $cartItems);
        foreach ($cartItems as $cartItem) {
            $isSuccess = Stock::removeItemInStockById($cartItem['stockId'], $cartItem['quantity']);
            
            if(!$isSuccess) return redirect()->route('cashier.index')->with('errorMessage', 'Stok barang habis!!');
        }
        return redirect()->route('cashier.index')->with('successMessage', 'Checkout berhasil!!');;
    }

    public function saveTransaction($userId, $customerId, $soldStockItems) {
        $transactionHeader = new TransactionHeader();
        $transactionHeader->customer_id  = $customerId;
        $transactionHeader->user_id = $userId;
        $transactionHeader->save();
        foreach ($soldStockItems as $soldStockItem) {
            $goldId = Stock::all()->find($soldStockItem['stockId'])->gold_id;
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_header_id = $transactionHeader->id;
            $transactionDetail->gold_id = $goldId;
            $transactionDetail->quantity = $soldStockItem['quantity'];
            $transactionDetail->price = $soldStockItem['price'];
            $transactionDetail->save();
        }
    }
}
