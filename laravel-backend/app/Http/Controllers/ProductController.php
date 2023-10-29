<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class ProductController extends Controller
{
    public function getProductById($id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function index(Request $request)
    {   
        $products = [];
        if(empty($request->input('q')) && empty($request->input('category_id')) && empty($request->input('price'))){
            $products = Product::all();
        }

        if(!empty($request->input('price')) && !empty($request->input('category_id')) && !empty($request->input('q'))){
            $string = $request->input('price');

            // Split the string into an array using the '-' delimiter
            $numbersArray = explode('-', $string);
                    
                    // Trim extra spaces around the numbers
            $minNumber = trim($numbersArray[0]);
            $maxNumber = trim($numbersArray[1]);
            
            $q = $request->input('q');

            $products = Product::join('subcategories', 'products.subcategory', '=', 'subcategories.id')
                ->where('subcategories.category_id', '=', $request->input('category_id'))
                ->select('products.*')
                ->where('price', '>', $minNumber)
                ->where('price', '<', $maxNumber)
                ->where('products.name', 'LIKE', "%q%")
                ->select('products.*')
                ->get();
        } else if(!empty($request->input('price')) && !empty($request->input('q'))){
            $string = $request->input('price');

            // Split the string into an array using the '-' delimiter
            $numbersArray = explode('-', $string);
                    
                    // Trim extra spaces around the numbers
            $minNumber = trim($numbersArray[0]);
            $maxNumber = trim($numbersArray[1]);
            $q = $request->input('q');
            $products = Product::where('price', '>=', intval($minNumber))
                ->where('price', '<=', intval($maxNumber))
                ->where('name', 'LIKE', "%q%")
                ->get();
        } else if(!empty($request->input('category_id')) && !empty($request->input('q'))){
            $q = $request->input('q');
            $products = Product::join('subcategories', 'products.subcategory', '=', 'subcategories.id')
                ->where('subcategories.category_id', '=', $request->input('category_id'))
                ->select('products.*')
                ->where('products.name', 'LIKE', "%q%")
                ->select('products.*')
                ->get();
        } else if(!empty($request->input('category_id')) && !empty($request->input('price'))){
            $string = $request->input('price');

            // Split the string into an array using the '-' delimiter
            $numbersArray = explode('-', $string);
                    
                    // Trim extra spaces around the numbers
            $minNumber = trim($numbersArray[0]);
            $maxNumber = trim($numbersArray[1]);

            $products = Product::join('subcategories', 'products.subcategory', '=', 'subcategories.id')
                ->where('subcategories.category_id', '=', $request->input('category_id'))
                ->select('products.*')
                ->where('price', '>=', intval($minNumber))
                ->where('price', '<=', intval($maxNumber))
                ->select('products.*')
                ->get();
        }else if(!empty($request->input('category_id'))){
            $products = Product::join('subcategories', 'products.subcategory', '=', 'subcategories.id')
                ->where('subcategories.category_id', '=', $request->input('category_id'))
                ->select('products.*')
                ->get();
        } else if(!empty($request->input('price'))){

            $string = $request->input('price');

            // Split the string into an array using the '-' delimiter
            $numbersArray = explode('-', $string);
                    
                    // Trim extra spaces around the numbers
            $minNumber = trim($numbersArray[0]);
            $maxNumber = trim($numbersArray[1]);
            
            $products = Product::where('price', '>=', intval($minNumber))
            ->where('price', '<=', intval($maxNumber))
            ->get();
        } else if(!empty($request->input('q'))){
            $q = $request->input('q');
            $products = Product::where('name', 'LIKE', "%q%")
                ->get();
        }
        if(!empty($request->input('star'))){
            $star = intval($request->input('star'));
            $products2 = [];
            foreach($products as $product){
                if($product['star'] >= $star){
                    array_push($products2, $product);
                }
            }
            $products = $products2;
        
        }
        return response()->json($products);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Create a new product
        $product = Product::create([
            'name' => $request->input('name'),
            'subcategory' => 1,
            'price' => $request->input('price'),
            'image' => $this->downloadAndSaveImage($request->input('image')),
            'description' => $request->input('description')
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    public function show($id)
    {
        // Return a specific product by ID
    }

    public function update(Request $request, $id)
    {
        // Validate and update product by ID
    }

    public function destroy($id)
    {
        // Delete product by ID
    }



    public function downloadAndSaveImage($url)
    {
        $client = new Client();
        
        try {
            // Send a GET request to the URL to download the image
            $response = $client->get($url);
            
            // Get the contents and file extension of the response
            $imageData = $response->getBody()->getContents();
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            
            // Generate a unique filename for the image
            $filename = uniqid() . '.' . $extension;
            
            // Save the image to the storage disk (public disk in this case)
            Storage::disk('public')->put($filename, $imageData);
            
            // Return the path to the saved image
            return $filename;
        } catch (\Exception $e) {
            // Handle any errors that occurred during the request
            return null;
        }
    }
}
