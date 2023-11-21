<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /*
        Variable 
        
        Request:

        Response:
        allCategory: [Category]
    */
    public function index() {
        return Inertia::render('Category/index',[
            'allCategory' => Category::all()
        ]);
    }

    public function create() {
        return Inertia::render('Category/Add/index');
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
            'name' => ['required', 'unique:categories,name']
        ]);

        $category = new Category();
        $category->name = $request['name'];
        $category->save();

        return redirect()->route('category.create')->with('successMessage', 'Kategory berhasil di buat !');
    }

    /*
        Variable 
        
        Request:

        Response:
        category: Category
    */
    public function edit(Category $category) {
        return Inertia::render('Category/Edit/index',[
            'category' => $category
        ]);
    }

    /*
        Variable 
        
        Request:
        name: String

        Response:
        successMessage: FlashMessage
    */
    public function update(Category $category) {
        $request = request()->validate([
            'name' => ['required', 'unique:categories,name']
        ]);

        $category->name = $request["name"];
        $category->save();

        return redirect()->route('category.index', $category->id)->with('successMessage', 'Kategori berhasil di ubah !!');
    }

    /*
        Variable 
        
        Request:

        Response:
        successMessage: FlashMessage
    */
    public function destroy(Category $category) {
        $category->delete();

        return redirect()->route('category.index')->with('successMessage', 'Kategori berhasil di hapus!!');
    }
}
