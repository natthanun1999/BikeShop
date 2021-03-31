<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Category;

class ProductAPIController extends Controller
{
    public function product_list($category_id = null) {
        if ($category_id) {
            $products = Product::where('category_id', $category_id)->get();
        } else {
            $products = Product::all();
        }

        return response()->json(array('ok' => true, 'products' => $products));
    }

    public function product_search(Request $request) {
        $query = $request->input('query');

        if ($query) {
            $products = Product::where('name', 'like', '%'.$query.'%')->get();
        } else {
            $products = Product::all();
        }

        return response()->json(array('ok' => true, 'products' => $products));
    }
}
