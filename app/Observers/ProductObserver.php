<?php

namespace App\Observers;

use App\Product;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     * NOT BEING USED CURRENTLY - REGISTER IN APP SERVICE PROVIDER
     * @param  \App\Product  $product
     * @return void
     */
    public function created(Product $product)
    {

        //dd('sldfjsdlfj');
        // if (is_null($product->order)) {
        //     //$product->order = Product::max('position') + 1;
        //     $product->order = 1;
        //     //$product->save();
        //     //$product->saveQuietly();
        //     //return;
        // }

        // $products = Product::where('id', '!=', $product->id)
        //     ->get();

        // foreach ($products as $product) {
        //     $product->order++;
        //     //$product->saveQuietly();
        //     $product->saveQuietly();
        // }

        // $lowerPriorityMeals = Meal::where('category_id', $meal->category_id)
        //     ->where('position', '>=', $meal->position)
        //     ->get();

        // foreach ($lowerPriorityMeals as $lowerPriorityMeal) {
        //     $lowerPriorityMeal->position++;
        //     $lowerPriorityMeal->saveQuietly();
        // }

    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
