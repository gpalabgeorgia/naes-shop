<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
    public function index() {
        // Get featured items
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'Yes')->where('status', 1)->limit(3)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 6);
        // Get New Products
        $newProducts = Product::orderBy('id', 'Desc')->where('status', 1)->limit(12)->get()->toArray();
        $page_name = 'Index';
        return view('front.index')->with(compact('page_name', 'featuredItemsChunk', 'featuredItemsCount', 'newProducts'));
    }
}
