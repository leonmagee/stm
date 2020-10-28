<?php

namespace App\Http\Controllers;

use App\Category;
use App\ProductCategories;
use App\ProductSubCategories;
use App\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Category::all();

        return view('categories.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);
        Category::create([
            'name' => $request->name,
        ]);
        session()->flash('message', 'A new category as been added.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);
        $category->name = $request->name;
        $category->save();
        session()->flash('message', 'Category name has been updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $sub_cats = SubCategory::where('category_id', $category->id)->get();
        foreach ($sub_cats as $sub_cat) {
            $product_sub_cats = ProductSubCategories::where('sub_category_id', $sub_cat->id)->get();
            foreach ($product_sub_cats as $product_sub_cat) {
                $product_sub_cat->delete();
            }
        }
        foreach ($sub_cats as $sub_cat) {
            $sub_cat->delete();
        }
        $product_cats = ProductCategories::where('category_id', $category->id)->get();
        foreach ($product_cats as $product_cat) {
            $product_cat->delete();
        }
        $category->delete();
        session()->flash('message', 'Category, Sub Categories and data has been removed.');
        return redirect()->back();

    }
}
