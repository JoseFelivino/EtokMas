<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shelf;
use Inertia\Inertia;
use Illuminate\Support\Facades\Config;

class ShelfController extends Controller
{
    /*
        Variable 
        
        Request:

        Response:
        allShelf: [Shelf]
    */
    public function index() {
        //TODO: need to adjust rendering
        return Inertia::render('Shelf/index',[
            'allShelf' => Shelf::all()
        ]);
    }

    public function create() {
        //TODO: need to adjust rendering
        return Inertia::render('Shelf/Add/index');
    }

    /*
        Variable 
        
        Request:
        name: String

        Response:
        successMessage: FlashMessage
    */
    public function store() {
        $request = request()->validate([
            'name' => ['required', 'unique:shelves,name']
        ]);

        $shelf = new Shelf();
        $shelf->name = $request['name'];
        $shelf->save();

        return redirect()->route('shelf.create')->with('successMessage', 'Rak berhasil di buat !');
    }


    /*
        Variable 
        
        Request:

        Response:
        shelf: Shelf
    */
    public function edit(Shelf $shelf) {
        return Inertia::render('Shelf/Edit/index',[
            'shelf' => $shelf
        ]);
    }

    /*
        Variable 
        
        Request:
        name: String

        Response:
        successMessage: FlashMessage
    */
    public function update(Shelf $shelf) {
        $request = request()->validate([
            'name' => ['required', 'unique:shelves,name']
        ]);

        $shelf->name = $request["name"];
        $shelf->save();

        return redirect()->route('shelf.index', $shelf->id)->with('successMessage', 'Rak berhasil di ubah');
    }

    /*
        Variable 
        
        Request:

        Response:
        successMessage: FlashMessage
        errorMessage: FlashMessage
    */
    public function destroy(Shelf $shelf) {
        switch ($shelf->safeDelete()) {
            case Config::get('constants.ERROR_CODES.STOCK_DATA_EXISTS'):
                    return redirect()->route('shelf.index')->with('errorMessage', "Masih ada stok emas di dalam rak $shelf->name. Tolong di hapus terlebih dahulu!!");
                break;
            
            case Config::get('constants.ERROR_CODES.BOOKKEEPING_DATA_EXISTS'):
                return redirect()->route('shelf.index')->with('errorMessage', "Rak tidak bisa di hapus karena rak $shelf->name sudah ada di pembukuan!!");
                break;
        }

        return redirect()->route('shelf.index')->with('successMessage', 'Rak berhasil di hapus!!');
    }
}
