<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Gold;
use App\Models\Category;
use App\Models\GoldCaratCategory;
use App\Models\Shelf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class StockController extends Controller
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
        )->paginate(25);
        
        return Inertia::render('Stock/index',[
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
        
        Request:
        - id: Number

        Response:
        - stockResult: Object
    */
    public function searchStockByIdUsingAPIBasedRequest() {
        $request = request();
        $quantity = array_count_values($request['id']);

        $stockResult = Stock::getStockSearchByNameOrId($request['id'])->load(
            'gold'
        );

        $totalPrice = 0;

        foreach ($stockResult as $stock) {
            $totalPrice += $stock->price*$quantity[$stock->id];
        }
        return response()->json([
            'stockResult' => $stockResult,
            'quantity' => $quantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        stock: Stock
    */
    public function show(Stock $stock) {
        return Inertia::render('Stock/Show/index',[
            'stock' => $stock->load(
                'gold.user',
                'gold.shelf',
                'gold.goldCaratCategory',
                'gold.categories'
            )
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        allGoldCaratCategory: [GoldCaratCategory]
        allGoldCategory: [Category]
        allShelf: [Shelf]
    */
    public function create() {
        //TODO: adjust render page
        return Inertia::render('Stock/Add/index',[
            'allGoldCaratCategory' => GoldCaratCategory::all(),
            'allGoldCategory' => Category::all(),
            'allShelf' => Shelf::all()
        ]);
    }


    /*
        Variable 
        
        Request:
        gold_carat_category_id: Int 
        user_id: Int
        shelf_id: Int 
        category_id: [Int] 
        name: String 
        weight: float 
        quantity: int
        image: file

        Response:
        successMessage: FlashMessage
    */
    public function store() {
        $request = request()->validate([
            'gold_carat_category_id' => ['required'],
            'shelf_id' => ['required'],
            'category_id' => ['required'],
            'name' => ['required'],
            'weight' => ['required', 'numeric', 'gt:0'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'image' => ['required', 'image']
        ]);

        $img_path = "/storage/{$request['image']->store('goldimages')}";
        $loggedInUserId = Auth::id();
        $gold = Gold::getAndSaveNewGoldInstance(
            $request['gold_carat_category_id'],
            $loggedInUserId,
            $request['shelf_id'],
            $request['category_id'],
            $request['name'],
            $request['weight'],
            $img_path 
        );

        $stock = Stock::getAndSaveNewStockInstanceWithCalculatedPrice(
            $gold->id,
            $request['quantity']
        );

        return redirect()->route('stock.create')->with([
            'successMessage' => "Produk emas baru berhasil di buat dengan id:$stock->id ",
            'goldId' =>$stock->id
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        currentItemGold: Stock
        allGoldCaratCategory: [GoldCaratCategory]
        allGoldCategory: [Category]
        allShelf: [Shelf]
    */
    //TODO: not tested yet
    public function edit(Stock $stock) {
        //TODO: adjust render page
        return Inertia::render('Stock/Edit/index',[
            'currentItemGold' => $stock->load(
                'gold',
                'gold.categories'
            ),
            'allGoldCaratCategory' => GoldCaratCategory::all(),
            'allGoldCategory' => Category::all(),
            'allShelf' => Shelf::all()
        ]);
    }

    /*
        Variable 
        
        Request:
        gold_carat_category_id: Int 
        shelf_id: Int 
        category_id: [Int]
        name: String 
        weight: float 
        quantity: int
        image: file

        Response:
        successMessage: FlashMessage
    */

    public function update(Stock $stock) {
        $request = request()->validate([
            'gold_carat_category_id' => ['required'],
            'shelf_id' => ['required'],
            'category_id' => ['required'],
            'name' => ['required'],
            'weight' => ['required', 'numeric', 'gt:0'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'image' => ['nullable', 'image']
        ]);
        
        $img_path = '';

        if($request['image'] == null) {
            $img_path = $stock->gold->img_path;
        } else {
            $img_path = "/storage/{$request['image']->store('goldimages')}";
            $toDelete = '';
            if(str_contains($stock->gold->img_path, '/images/gold')) {
                $toDelete = $stock->gold->img_path;
            } else {
                $toDelete = str_replace('/storage/', '', $stock->gold->img_path);
            }
            
            if(Storage::exists($toDelete)){
                Storage::delete($toDelete);
            } else if(File::exists(public_path($toDelete))) {
                File::delete(public_path($toDelete));
            } else{
                return redirect()->route('stock.index')->with('errorMessage', 'Produk gagal di hapus!');
            }
        }

        $loggedInUserId = Auth::id();
        $stock->updateWithCalculatedPrice(
            $request['gold_carat_category_id'],
            $loggedInUserId,
            $request['shelf_id'],
            $request['category_id'],
            $request['name'],
            $request['weight'],
            $img_path,
            $request['quantity']
        );
        return redirect()->route('stock.show', $stock->id)->with('successMessage', 'Produk emas berhasil di ubah!');
    }

    /*
        Variable 
        
        Request:

        Response:
        successMessage: FlashMessage
    */
    public function destroy(Stock $stock) {
        $imgPath = '';
        if(str_contains($stock->gold->img_path, '/images/gold')) {
            $imgPath = $stock->gold->img_path;
        } else {
            $imgPath = str_replace('/storage/', '', $stock->gold->img_path);
        }
        
        
        if(Storage::exists($imgPath)){
            Storage::delete($imgPath);
        } else if(File::exists(public_path($imgPath))) {
            File::delete(public_path($imgPath));
        } else{
            return redirect()->route('stock.index')->with('errorMessage', 'Produk gagal di hapus!');
        }

        $stock->safeDelete();
        return redirect()->route('stock.index')->with('successMessage', 'Produk emas berhasil di hapus!');
    }

    public function getStockSearchByNameOrId($id) {
        $stock = Stock::all();

        if($id) {
            $stock = Stock::getStockSearchByNameOrId($id);
        }

        return $stock;
    }
}
