<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\GoldCaratCategory;

class GoldCaratCategoryController extends Controller
{
     /*
        Variable 
        
        Request:

        Response:
        allGoldCaratCategory: [GoldCaratCategory]
    */
    public function index() {
        $allGoldCaratCategory = GoldCaratCategory::all();
        //TODO: adjust render page
        return Inertia::render('GoldCarat/index',[
            'allGoldCaratCategory' => $allGoldCaratCategory
        ]);
    }

    public function create() {
        return Inertia::render('GoldCarat/Add/index');
    }

    /*
        Variable 
        
        Request:
        carat: Int
        price: Int
        fee: Int

        Response:
    */
    public function store() {
        //TODO: add validation
        $request = request()->validate([
            'carat' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'fee' => ['required', 'numeric']
        ]);
        
        if(GoldCaratCategory::isCaratExist($request['carat'])) return redirect()->route('goldCarat.create')->with('errorMessage', 'Kategori karat emas sudah pernah dibuat!');
        GoldCaratCategory::getAndSaveGoldCaratCategoryInstance($request['carat'], $request['price'], $request['fee']);
        return redirect()->route('goldCarat.create')->with('successMessage', 'Kategori karat emas baru berhasil dibuat!');
    }

    /*
        Variable 
        
        Request:

        Response:
        goldCaratCategory: [GoldCaratCategory]
    */


    public function edit(GoldCaratCategory $goldCaratCategory) {
        //TODO: adjust render page
        return Inertia::render('GoldCarat/Edit/index',[
            'goldCaratCategory' => $goldCaratCategory
        ]);
    }

    /*
        Variable 
        
        Request:
        carat: Int
        price: Int
        fee: Int

        Response:
    */

    public function update(GoldCaratCategory $goldCaratCategory) {
        $request = request()->validate([
            'carat' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'fee' => ['required', 'numeric']
        ]);
        $goldCaratCategory->updateWithGoldStockPrice($request['carat'], $request['price'], $request['fee']);
        return redirect()->route('goldCarat.index', $goldCaratCategory->id)->with('successMessage', 'Kategori karat emas berhasil diubah!');
    }

    public function destroy(GoldCaratCategory $goldCaratCategory) {
        $goldCaratCategory->delete();
        return redirect()->route('goldCarat.index')->with('successMessage', 'Kategori karat emas berhasil dihapus!');
    }
}
