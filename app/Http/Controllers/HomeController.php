<?php

namespace App\Http\Controllers;

use App\Helpers\ParentCategoriesHelper;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $parentCategories = ParentCategoriesHelper::returnParentCategories();
        $brands = Brand::all();
        $parentConverseCategory = Category::where('name', 'Converse')->first();
        $latestConverse = $parentConverseCategory->allProducts(20)->get();
        $parentVansCategory = Category::where('name', 'Vans')->first();
        $latestVans = $parentVansCategory->allProducts(20)->get();

        return view('home', [
            "brands" => $brands,
            "parentCategories" => $parentCategories,
            "latestConverse" => $latestConverse,
            "latestVans" => $latestVans
        ]);
    }



}
