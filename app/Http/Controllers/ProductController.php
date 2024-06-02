<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploadHelper;
use App\Helpers\SkuHelper;
use App\Helpers\SummerNoteExtract;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Helpers\OptionsHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index() {
        $products = Product::withTrashed()->latest()->paginate(5);
        return view('admin.product.index',['products'=> $products]);
    }

    public function create() {
        $brands = Brand::all();
        $categories = Category::all();
        $sizes = Size::all();
        $tags = Tag::all();
        return view('admin.product.add',[
            'brands' => $brands,
            'categories' => $categories,
            'sizes' => $sizes,
            'tags'=>$tags
        ]);
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:products,name',
            'sale_price' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'intro' => 'nullable|string',
            'material' => 'nullable|string',
            'color' => 'nullable|string',
            'sizes' => 'array', // Assuming this is the name of the select element for sizes
            'feature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_images.*' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation rules for each product image
            'description' => 'nullable|string', // Assuming this is the name of the textarea element for product description
            'category_id'=> 'nullable|exists:categories,id',
            'brand_id'=> 'nullable|exists:brands,id',
        ]);


//        dd($validatedData['product_images']);
        try {
            DB::beginTransaction();
            $productName = $validatedData['name'];
            $featureImage = $request->file('feature_image');
            $featureImageInfoArr = ImageUploadHelper::uploadImage($featureImage, "products/$productName");

            $content = SummerNoteExtract::extractSummerNote($request);


            $product = Product::create([
                'name' => $validatedData['name'],
                'sale_price' => $validatedData['sale_price'],
                'price' => $validatedData['price'],
                'feature_image_path' => $featureImageInfoArr['imagePath'],
                'feature_image_name' => $featureImageInfoArr['imageName'],
                'feature_image_origin_name' => $featureImageInfoArr['originName'],
                'content' => $content,
                'intro' => $validatedData['intro'],
                'material' => $validatedData['material'],
                'color' => $validatedData['color'],
                'user_id' => Auth::id(),
                'category_id' => $validatedData['category_id'],
                'brand_id' => $validatedData['brand_id'],
            ]);


//            $product->productImages()
            foreach ($validatedData['product_images'] as $productImage) {
                $featureImageInfoArr = ImageUploadHelper::uploadImage($productImage, "products/$productName");
                $product->productImages()->create([
                    'image_path' => $featureImageInfoArr['imagePath'],
                    'image_name' => $featureImageInfoArr['imageName'],
                    'image_origin_name' => $featureImageInfoArr['originName']
                ]);
            }

            $sku = SkuHelper::generateSKU($product->id, $product->name, '');// sku for the product not relying on sizes

//            $product->tags()
            $product->tags()->detach();
// Iterate over the updated list of tag names
            foreach ($request->input('tags', []) as $tagName) {
                // Get the tag by name or create a new one if it doesn't exist
                $tagName = trim($tagName);
                $tag = Tag::firstOrCreate(['name' => $tagName]);

                // Attach the tag to the product if it's not already attached
                if (!$product->tags()->where('tag_id', $tag->id)->exists()) {
                    $product->tags()->attach($tag->id);
                }
            }
//           1 tag is the sku
            $tag = Tag::firstOrCreate(['name' => $sku]);
            // Attach the tag to the product if it's not already attached
            if (!$product->tags()->where('tag_id', $tag->id)->exists()) {
                $product->tags()->attach($tag->id);
            }
//           $product->sizes() quantity
            $totalQuantity = 0;
            foreach ($request->input('sizes', []) as $sizeId) {
                $quantityFieldName = 'qtyInput' . $sizeId;
                $quantity = $request->input($quantityFieldName, 0);
                $totalQuantity += $quantity;
                // Attach the product size to the product
                $product->sizes()->attach($sizeId, ['quantity' => $quantity]);
            }
//            create remaining columns data
            $product->update([
                'total_quantity' => $totalQuantity, // Update the total_quantity column to 100\
                'sku' => $sku,
                // You can add more columns to update here if needed
            ]);
            DB::commit();
//            dd("success");
            return redirect()->route('products')->with('success', 'Product created successfully.');
        } catch (\Exception $exception) {
            // If an exception occurs, rollback the transaction
            DB::rollback();
            $detailedError = 'Message: '.$exception->getMessage() . ' --- File: ' . $exception->getFile() . ' --- Line: ' . $exception->getLine();
            Log::error($detailedError);

            // Flash the detailed error message to the session
            return back()->with('error', $detailedError);
        }
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
        $sizes = Size::all();
        $tags = Tag::all();

        // Additional data passed to the view
        $selectedSizes = $product->sizes();
        $selectedTags = $product->tags();
        $selectedCatId = $product->category_id;
        $selectedBrandId = $product->brand_id;

        return view('admin.product.edit',[
            'brands' => $brands,
            'categories' => $categories,
            'sizes' => $sizes,
            'tags'=>$tags,
            'product'=>$product,
            'selectedSizes' => $selectedSizes,
            'selectedTags' => $selectedTags,
            'selectedCatId' => $selectedCatId,
            'selectedBrandId' => $selectedBrandId,
        ]);
    }

    public function fetchQuantity(Request $request) {
        $sizeId = $request->input('sizeId');
        $productId = $request->input('productId');

//        dd($sizeId.'abc'.$productId);
        // If you passed data directly without a key, retrieve it like this:
        // $size = $request->size;
        $productSize = ProductSize::where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->first();

        // Query to fetch the quantity for the given size
        $quantity = $productSize ? $productSize->quantity : null;
        // If quantity is not found, default to 0
        $quantity = $quantity ?? 0;
        // Return the quantity as JSON response

        return response()->json(['quantity' => $quantity]);
    }
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:products,name',
            'sale_price' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'intro' => 'nullable|string',
            'material' => 'nullable|string',
            'color' => 'nullable|string',
            'sizes' => 'array', // Assuming this is the name of the select element for sizes
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation rules for each product image
            'description' => 'nullable|string', // Assuming this is the name of the textarea element for product description
            'category_id'=> 'nullable|exists:categories,id',
            'brand_id'=> 'nullable|exists:brands,id',
        ]);

        try {
            DB::beginTransaction();

            // Retrieve the product by ID
            $product = Product::findOrFail($id);

            // Update the product attributes
            $product->name = $validatedData['name'];
            $product->sale_price = $validatedData['sale_price'];
            $product->price = $validatedData['price'];
            $product->intro = $validatedData['intro'];
            $product->material = $validatedData['material'];
            $product->color = $validatedData['color'];
            $product->category_id = $validatedData['category_id'];
            $product->brand_id = $validatedData['brand_id'];

            // Update the feature image if provided
            if ($request->hasFile('feature_image')) {
                $featureImage = $request->file('feature_image');
                $featureImageInfoArr = ImageUploadHelper::uploadImage($featureImage, "products/{$product->name}");
                $product->feature_image_path = $featureImageInfoArr['imagePath'];
                $product->feature_image_name = $featureImageInfoArr['imageName'];
                $product->feature_image_origin_name = $featureImageInfoArr['originName'];
            }

            // Update the product content
            $product->content = SummerNoteExtract::extractSummerNote($request);

            // Update product images if provided
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $productImage) {
                    $featureImageInfoArr = ImageUploadHelper::uploadImage($productImage, "products/{$product->name}");
                    $product->productImages()->create([
                        'image_path' => $featureImageInfoArr['imagePath'],
                        'image_name' => $featureImageInfoArr['imageName'],
                        'image_origin_name' => $featureImageInfoArr['originName']
                    ]);
                }
            }

            // Update product tags
            $product->tags()->sync([]);

            foreach ($request->input('tags', []) as $tagName) {
                $tagName = trim($tagName);
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $product->tags()->attach($tag->id);
            }

            // Update product sizes and quantities
            $totalQuantity = 0;
            $product->sizes()->detach();

            foreach ($request->input('sizes', []) as $sizeId) {
                $quantityFieldName = 'qtyInput' . $sizeId;
                $quantity = $request->input($quantityFieldName, 0);
                $totalQuantity += $quantity;
                $product->sizes()->attach($sizeId, ['quantity' => $quantity]);
            }

            // Update remaining columns and save the product
            $sku = SkuHelper::generateSKU($product->id, $product->name, '');

            $product->total_quantity = $totalQuantity;
            $product->sku = $sku;

            $product->save();

            DB::commit();

            return redirect()->route('products.edit')->with('success', 'Product updated successfully.');
        } catch (\Exception $exception) {
            // If an exception occurs, rollback the transaction
            DB::rollback();
            $detailedError = 'Message: '.$exception->getMessage() . ' --- File: ' . $exception->getFile() . ' --- Line: ' . $exception->getLine();
            Log::error($detailedError);

            // Flash the detailed error message to the session
            return back()->with('error', $detailedError);
        }
    }


    public function delete($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect(route('products'));
    }
    public function restore(Request $request)
    {
        //get data passed from Ajax
        $id = $request->input('id');
        // Fetch categories based on showDeleted value
        $softDeletedProduct = Product::withTrashed()->find($id);
//        dd($softDeleted);
        // Check if the category exists
        if ($softDeletedProduct) {

            $softDeletedProduct->restore();

            // Category found, you can perform further actions here
            return response()->json(['softDeletedProduct' => $softDeletedProduct]);
        } else {
            // Category not found
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }
    public function search(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('search');

        // Query the posts table for records where the title or description matches the search term
        $products = Product::where(function ($query) use ($searchTerm) {
            $query->where('id', 'like', "%$searchTerm%")
                ->orWhere('name', 'like', "%$searchTerm%")
                ->orWhere('sale_price', 'like', "%$searchTerm%")
                ->orWhere('price', 'like', "%$searchTerm%");
        })
            // Use orWhereHas to search in related models
            ->orWhereHas('category', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->orWhereHas('brand', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            })
            ->latest()->paginate(5);;

        // Return the results to your view along with the search term
        return view('admin.product.index',compact('products', 'searchTerm'));
    }

}
