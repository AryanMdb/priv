<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Exports\ProductExport;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function index(Request $request)
    // {
    //     try {
    //         $query = Product::orderByRaw('CASE WHEN `order` IS NULL OR `order` = 0 THEN 1 ELSE 0 END')
    //             ->orderBy('order', 'asc')
    //             ->orderBy('id', 'desc');

    //         if ($request->has('category') && $request->category != '') {
    //             $query->where('category_id', $request->category);
    //         }

    //         $allowed = [10, 25, 50, 100];
    //         $input = (int) $request->input('entries', 10);

    //         if (!in_array($input, $allowed)) {
    //             $closest = null;
    //             $minDiff = PHP_INT_MAX;
    //             foreach ($allowed as $value) {
    //                 $diff = abs($value - $input);
    //                 if ($diff < $minDiff) {
    //                     $minDiff = $diff;
    //                     $closest = $value;
    //                 } elseif ($diff == $minDiff && $value > $closest) {
    //                     $closest = $value;
    //                 }
    //             }
    //             $entries = $closest;
    //         } else {
    //             $entries = $input;
    //         }

    //         $products = $query->paginate($entries)->appends($request->query());
    //         $categories = Category::all();

    //         return view('admin.product.index', compact('products', 'categories', 'entries'));
    //     } catch (Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    public function index(Request $request)
    {
        try {
            $query = Product::orderByRaw('CASE WHEN `order` IS NULL OR `order` = 0 THEN 1 ELSE 0 END')
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc');

            // Filter by category
            if ($request->has('category') && $request->category != '') {
                $query->where('category_id', $request->category);
            }

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            }

            // Handle pagination entries
            $allowed = [10, 25, 50, 100];
            $input = (int) $request->input('entries', 10);

            $entries = in_array($input, $allowed) ? $input : collect($allowed)
                ->sortBy(fn($value) => abs($value - $input))
                ->first();

            $products = $query->paginate($entries)->appends($request->query());
            $categories = Category::all();

            // Return JSON for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'products' => view('admin.product.partials.product_table', compact('products'))->render()
                ]);
            }

            return view('admin.product.index', compact('products', 'categories', 'entries'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $categories = Category::active()->get();
            $subcategories = SubCategory::active()->get();
            return view('admin.product.create', compact('categories', 'subcategories'));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $requestData = $request->all();

            $validator = Validator::make($requestData, [
                'category_id' => 'required',
                'title' => 'required',
                'image' => 'required|array|max:10',
                'image.*' => 'image|mimes:jpeg,png,jpg|required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $imageNames = [];

            if ($request->file('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = Str::uuid() . '.' . $image->extension();
                    $image->move(public_path('storage/product'), $imageName);
                    $imageNames[] = $imageName;
                }
            }

            if ($request->selling_price != "0" && $request->selling_price != null) {
                $discount_amount = $request->total_amount - $request->selling_price;
                $discount_percentage = ($request->total_amount > 0) ? ($discount_amount / $request->total_amount) * 100 : 0;
            }

            $newOrderNumber = 1;
            Product::where('order', '>=', $newOrderNumber)
                ->update([
                    'order' => DB::raw('`order` + 1'),
                    'updated_at' => now(),
                ]);

            $product = Product::create([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id ?? '',
                'title' => $request->title,
                'selling_price' => $request->selling_price ?? 0,
                'total_amount' => $request->total_amount ?? 0,
                'out_of_stock' => $request->out_of_stock ?? 0,
                'image' => json_encode($imageNames),
                'discount' => $discount_percentage ?? null,
                'order' => $newOrderNumber,
                'description' => $request->description,
            ]);

            if (!empty($request->inventory)) {
                foreach ($request->inventory as $inventory) {
                    if (!empty($inventory['quantity']) && isset($inventory['price']) && isset($inventory['discount_price'])) {
                        $discount = "";

                        if ($inventory['price'] > 0 && $inventory['discount_price'] > 0) {
                            $discount = (($inventory['price'] - $inventory['discount_price']) / $inventory['price']) * 100;
                            $discount = number_format($discount, 2, '.', '');
                        }

                        ProductInventory::create([
                            'product_id' => $product->id,
                            'quantity' => $inventory['quantity'],
                            'actual_price' => $inventory['price'],
                            'selling_price' => $inventory['discount_price'],
                            'discount' => $discount,
                        ]);
                    }
                }
            }

            if ($product) {
                Alert::success('Success', 'Product Created Successfully!');
                return redirect()->route('product.index');
            } else {
                Alert::error('Failed', 'Please Try Again!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::find($id);
            return view('admin.product.view', compact('product'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::find($id);
            $product_inventory = ProductInventory::where('product_id', $id)->get();
            $categories = Category::active()->get();
            $subcategories = SubCategory::active()->get();
            $subcategories = SubCategory::active()->get();
            return view('admin.product.edit', compact('subcategories', 'categories', 'product', 'product_inventory'));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            // Step 1: Retrieve all the data from the request.
            $requestData = $request->all();

            // Step 2: Validate the incoming request data.
            $validator = Validator::make($requestData, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'array|max:10',
                'image-order' => 'required|json',
            ]);

            // Step 3: If validation fails, redirect back with error messages.
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // Step 4: Find the product by ID.
            $product = Product::find($id);

            // Step 5: If the product is not found, show an error message and redirect back.
            if (!$product) {
                Alert::error('Failed', 'Product not found!');
                return redirect()->back();
            }

            // Step 6: Initialize arrays for uploaded and removed images.
            $uploadedImages = [];
            $removedImages = json_decode($request->removed_images ?? '[]', true);

            // Step 7: Delete removed images from the storage directory.
            foreach ($removedImages as $image) {
                $filePath = public_path('storage/product/' . $image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Step 8: Decode existing product images or initialize as an empty array.
            $existingImages = json_decode($product->image, true) ?: [];

            // Step 9: Process new uploaded images.
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    // Generate a unique name for the image and upload it.
                    $uploadedImageName = Str::uuid() . '.' . $image->extension();
                    $uploadedImages[] = $uploadedImageName;
                    $image->move(public_path('storage/product/'), $uploadedImageName);
                }
            }

            // Step 10: Merge remaining images with newly uploaded images.
            $remainingImages = array_diff($existingImages, $removedImages);
            $mergedImages = array_merge($remainingImages, $uploadedImages);

            // Step 11: Retrieve and validate the image order.
            $imageOrder = [];
            if ($request->has('image-order')) {
                $imageOrder = json_decode($request->input('image-order'), true);
            }

            // Step 12: Merge the images in the correct order.
            $finalImages = array_merge(
                array_intersect($imageOrder, $mergedImages),  // Match ordered images
                array_diff($mergedImages, $imageOrder)        // Add remaining images
            );

            // Remove duplicates and ensure the order is correct.
            $finalImages = array_values(array_unique($finalImages));

            // Log the final images for debugging
            Log::info('Final Images:', $finalImages);

            // Step 13: Update the product record with new data.

            if ($request->selling_price != "0" && $request->selling_price != null) {
                $discount_amount = $request->total_amount - $request->selling_price;
                $discount_percentage = ($request->total_amount > 0) ? ($discount_amount / $request->total_amount) * 100 : 0;
            }

            $product->update([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'title' => $request->title,
                'selling_price' => $request->selling_price ?? 0,
                'total_amount' => $request->total_amount ?? 0,
                'out_of_stock' => $request->out_of_stock ?? 0,
                'image' => json_encode($finalImages),
                'description' => $request->description ?? null,
                'discount' => $discount_percentage ?? null,
            ]);

            if ($request->has('inventory')) {
                $product->inventory()->delete();

                foreach ($request->inventory as $inventory) {
                    // Ensure 'price' is not null before proceeding
                    if (!is_null($inventory['price'])) {
                        $discount = ""; // Default value as string

                        if (!is_null($inventory['discount_price']) && $inventory['discount_price'] != "0") {
                            $discount = (($inventory['price'] - $inventory['discount_price']) / $inventory['price']) * 100;
                            $discount = number_format($discount, 2, '.', '');

                            // If discount is a whole number, ensure it has ".00"
                            if (floor($discount) == $discount) {
                                $discount = number_format($discount, 2, '.', '');
                            }
                        }

                        $product->inventory()->create([
                            'quantity' => $inventory['quantity'],
                            'actual_price' => $inventory['price'],
                            'selling_price' => $inventory['discount_price'],
                            'discount' => "$discount", // ✅ Always formatted as "XX.XX"
                        ]);
                    }
                }
            }


            // Step 14: Return success message and redirect.
            Alert::success('Success', 'Product Updated Successfully!');
            return redirect()->back();

        } catch (Exception $e) {
            // Step 15: Catch and log any errors, then return failure message.
            Log::error('Error updating product: ' . $e->getMessage());
            Alert::error('Failed', 'An error occurred while updating the product.');
            return redirect()->back();
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (isset($id) && !empty($id)) {
                $make = Product::find($id);
                if (isset($make)) {
                    $make->delete();
                    Alert::success('Success', 'Product Deleted Successfully!');
                    return redirect()->route('product.index');
                } else {
                    Alert::error('Failed', 'Please Try Again!');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Please send ID!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('id'); // 'id' corresponds to the parameter sent in the AJAX request
        $subcategories = Subcategory::where('category_id', $categoryId)->orderBy('id', 'desc')->get();

        return response()->json($subcategories);
    }

    public function status(Request $request)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData)) {
                $id = $requestData['id'];
                if (isset($requestData['switch'])) {
                    $value = true;
                } else {
                    $value = false;
                }
                $makes = Product::find($id);
                $makes->status = $value;
                $makes->save();
                if ($makes) {
                    Alert::success('Success', 'Product Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductData()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function updateOrder(Request $request)
    {
        try {
            $orderData = $request->input('order');

            foreach ($orderData as $item) {
                Product::where('id', $item['id'])->update(['order' => $item['position']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Sorting update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
