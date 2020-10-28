<?php

namespace App\Http\Controllers;

use App\ProductSubCategories;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'sub_cat_name' => 'required|min:3',
            'category_id' => 'required',
        ]);
        SubCategory::create([
            'name' => $request->sub_cat_name,
            'category_id' => $request->category_id,
        ]);
        session()->flash('message', 'A new sub category as been added.');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $category)
    {
        return view('categories.show-sub', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $category)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);
        $category->name = $request->name;
        $category->save();
        session()->flash('message', 'Sub Category name has been updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $category)
    {
        $sub_cats = ProductSubCategories::where('sub_category_id', $category->id)->get();
        foreach ($sub_cats as $sub_cat) {
            $sub_cat->delete();
        }
        $category->delete();
        session()->flash('message', 'Category and data has been removed.');
        return redirect()->back();
    }
}
