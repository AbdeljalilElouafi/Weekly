<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;  

use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        

        Category::create([
            'nom' => $request->nom,
            'slug' => $request->slug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        

        $category->update([
            'nom' => $request->nom,
            'slug' => $request->slug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
   
    }


    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore(); 

        return redirect()->route('categories.index')->with('success', 'Category restored successfully');
    }

    /**
     * Permanently delete the specified resource.
     */
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete(); 

        return redirect()->route('categories.index')->with('success', 'Category permanently deleted');
    }

    public function trashed()
    {
        
        $categories = Category::onlyTrashed()->get();
        return view('categories.trashed', compact('categories'));
        
    }


}
