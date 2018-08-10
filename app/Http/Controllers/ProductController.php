<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function attach_product(Product $product, User $user)
    {
      $product->user_id = $user->id;
      $product->save();
      return response()->json(array('message' => 'Successfully Attached'), 200);
    }

    public function remove_product(Product $product, User $user)
    {
      $product->user_id = null;
      $product->save();
      return response()->json(array('message' => 'Successfully Removed'), 204);
    }

    public function get_products(User $user)
    {
      $products = Product::where('user_id', '=', $user->id)->get();
      return response()->json($products);
    }

    public function upload_image(Request $request, Product $product)
    {
      $fileName = $_FILES['image']['name'];
      $destinationPath = base_path() . '/public/uploads/images/product' . $fileName;
      Image::make($_FILES['image']['tmp_name'])->save($destinationPath);
      $product->image = $destinationPath;
      $product->save();
      return response()->json($product, 200);
    }
}
