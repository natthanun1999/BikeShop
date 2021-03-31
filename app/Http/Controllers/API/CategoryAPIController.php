<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryAPIController extends Controller
{
    public function category_list() {
        $categories = Category::all();
        return response()->json(array('ok' => true, 'categories' => $categories));
    }
}
