<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Category;

class Controller extends BaseController
{
//     use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//     public function show($id)
// {
//     $category = Category::findOrFail($id);
//     $features = explode('|', $category->features);

//     return view('frontend.category-detail', compact('category', 'features'));
// }

}
