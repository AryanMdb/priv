<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\StoreLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\Models\ManageForm;
use App\Models\DeliveryCharge;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ManageFormResource;
use App\Http\Requests\CartRequest;
use App\Http\Requests\OrderRequest;
use App\Services\FCMService;
use App\Events\OrderPlacedEvent;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\Minimum_order_value;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{


    public function getCategories(Request $request)
    {
        try {
            $name = $request->name;
            $categories = Category::with('subCategory', 'products')->active();
            if ($name) {
                $categories->where('title', 'like', '%' . $name . '%')
                    ->orWhereHas('subCategory', function ($query) use ($name) {
                        $query->where('title', 'like', '%' . $name . '%');
                    })
                    ->orWhereHas('products', function ($query) use ($name) {
                        $query->where('title', 'like', '%' . $name . '%');
                    });
            }
            $categories = $categories->latest()->get();

            $cateGories = [];

            foreach ($categories as $item) {
                if (!empty($item['products'])) {
                    $itemArray = $item->toArray();
                    $count = 0;
                    foreach ($itemArray['products'] as $product) {
                        $modifiedImages = ProductResource::correctImageFormat($product['image']);
                        $itemArray['products'][$count]['image'] = $modifiedImages[1];
                        $itemArray['products'][$count]['image_with_url'] = $modifiedImages[0];
                        $count++;
                    }

                    $itemArray['products'] = $itemArray['products'];

                } else {
                    $itemArray = $item->toArray();
                }

                $cateGories[] = $itemArray;
            }



            return $this->sendResponse($cateGories, 'Categories list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            $name = $request->name;
            $category = $request->category_id;
            $subcategories = SubCategory::active();
            if ($name) {
                $subcategories->where('title', 'like', '%' . $name . '%');
            }
            if ($category) {
                $subcategories->where('category_id', $category);
            }
            $subcategories = $subcategories->latest()->get();

            return $this->sendResponse(SubcategoryResource::collection($subcategories), 'Sub Catgories list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function getProducts(Request $request)
    {
        try {
            $name = $request->name;
            $category = $request->category_id;
            $subcategory = $request->subcategory_id;
            $products = Product::active();
            if ($name) {
                $products->where('title', 'like', '%' . $name . '%');
            }
            if ($category) {
                $products->where('category_id', $category);
            }
            if ($subcategory) {
                $products->where('subcategory_id', $subcategory);
            }
            $products = $products->latest()->get();
            return $this->sendResponse(ProductResource::collection($products), 'Products list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function addToCart(CartRequest $request)
    {

        try {
            $product = Product::with('inventory')->find(id: $request->product_id);
            if (!$product) {
                return $this->sendError([], 'Product not found.', 404);
            }
            if ($product->out_of_stock == 1 || $product?->inventory == '') {
                return $this->sendError([], 'Product is out of stock.', 407);
            }
            $cart = Cart::where(['user_id' => auth()->user()->id, 'status' => 0])->first();
            if ($cart) {
                $existingCartItem = CartItem::where('cart_id', $cart->id)
                    ->first();
                if ($existingCartItem && $existingCartItem->product->category_id !== $product->category_id) {
                    return $this->sendError([], 'Cannot add items from different categories to the same cart.', 409);
                }
            } else {
                $cart = Cart::create([
                    'user_id' => auth()->user()->id,
                    'category_id' => $product->category_id ?? 0,
                    'status' => 0,
                ]);
            }

            $existingCartProduct = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->first();
            if ($existingCartProduct) {
                return $this->sendResponse($cart, 'Product already exists in the cart.', 409);
            }

            $item_price = $request->item_price ?? 0;
            $item_quantity = $request->item_quantity ?? 0;
            $no_of_item = $request->no_of_items ?? 0;

            $item_total_price = $item_price * $no_of_item;

            $delivery_charge = 0;
            $cart_item = CartItem::create([
                'product_id' => $request->product_id ?? '',
                'inventory_id' => $request->inventory_id ?? 0,
                'cart_id' => $cart->id,
                'item_price' => $item_price,
                'item_quantity' => $item_quantity,
                'no_of_items' => $no_of_item,
            ]);

            $total_price = $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->item_price * $cartItem->no_of_items;
            });

            $category_charges = Category::find($product->category_id);

            if ($category_charges->delivery_charge !== null) {
                $min_values = json_decode($category_charges->min_value);
                $max_values = json_decode($category_charges->max_value);
                $delivery_charges = json_decode($category_charges->delivery_charge);

                foreach ($min_values as $index => $min_value) {
                    $max_value = $max_values[$index];
                    $charge = $delivery_charges[$index];
                    if ($total_price >= $min_value && $total_price <= $max_value) {
                        $delivery_charge = $charge;
                        break;
                    }
                }
            } else {
                $deliveryCharges = DeliveryCharge::all();
                foreach ($deliveryCharges as $deliveryCharge) {
                    if ($total_price >= $deliveryCharge->from_price && $total_price <= $deliveryCharge->to_price) {
                        $delivery_charge = $deliveryCharge->delivery_charges;
                        break;
                    }
                }
            }

            $cart->deliver_charges = $delivery_charge;
            $cart->save();
            $grant_total = $total_price + $delivery_charge;


            $cart->update([
                'total_price' => $total_price,
                'grant_total' => $grant_total,
                'discount' => 0,
                'discount_type' => null,
            ]);

            $user = User::find(auth()->user()->id);
            FCMService::send(
                $user->device_token,
                [
                    'user_id' => $user->id,
                    'type' => 'added_to_cart',
                    'title' => 'Product Added To Cart!',
                    'body' => 'Your product is added to cart.',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                ]
            );
            return $this->sendResponse($cart, 'Product added in cart successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function increaseDecreaseCartItemNo(Request $request, $id)
    {
        try {
            $cart_item = CartItem::find($id);
            if (!$cart_item) {
                return $this->sendError([], 'Cart item not found', 404);
            }
            $cart_item->update([
                'no_of_items' => $request->no_of_items ?? 0,
            ]);


            $cart = $cart_item->cart;
            $cart->total_price = $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->item_price * $cartItem->no_of_items;
            });
            $deliveryCharges = DeliveryCharge::all();
            $delivery_charge = $cart->deliver_charges ? $cart->deliver_charges : 0;

            foreach ($deliveryCharges as $deliveryCharge) {
                if ($cart->total_price >= $deliveryCharge->from_price && $cart->total_price <= $deliveryCharge->to_price) {
                    $delivery_charge = $deliveryCharge->delivery_charges;
                    break;
                }
            }

            if ($cart->total_price == 0) {
                $cart->delete();
                return $this->sendResponse([], 'Cart is empty and has been deleted', 200);
            }

            $cart->deliver_charges = $delivery_charge;
            $cart->grant_total = $cart->total_price + $delivery_charge;
            $cart->save();

            return $this->sendResponse($cart_item, 'Cart item updated successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function getAddToCartProducts($location_id = null, $distance = null)
    {

        try {

            $add_to_cart = Cart::with('cartItems')->where(['user_id' => auth()->user()->id, 'status' => '0'])->first();

            if (is_null($add_to_cart)) {
                return $this->sendResponse([], 'Cart is empty', 200);
            }

            $store_location = StoreLocation::first();

            if (!$store_location) {
                return $this->sendError([], 'Store location not found', 404);
            }
            if ($location_id && $distance != null) {
                $distance_ranges = json_decode($store_location->distance);

                $charge_ranges = json_decode($store_location->distance_charge);
                $charge = 0;
                if ($distance_ranges && $charge_ranges !== null)
                    for ($i = 0; $i < count($distance_ranges) - 1; $i++) {
                        if ($distance >= $distance_ranges[$i] && $distance < $distance_ranges[$i + 1]) {
                            $charge = $charge_ranges[$i];
                            break;
                        }
                    }
                if ($charge === 0 && $distance >= $distance_ranges[count($distance_ranges) - 1]) {
                    $charge = $charge_ranges[count($charge_ranges) - 1];
                }
            } else {
                $charge = 0;
                $distance = 0;
                $location_id = 0;
            }
            $coupon = null;
           
            $grant_total = $add_to_cart->total_price + $charge + $add_to_cart->deliver_charges - $add_to_cart->discount;

            $add_to_cart->update([
                'location_id' => (int) $location_id,
                'distance' => $distance,
                'grant_total' => $grant_total,
                'distance_charge' => $charge,
            ]);

            if ($location_id && $distance == null) {
                Location::where('user_id', auth()->user()->id)->update(['default_address' => 0]);
                Location::where('id', $location_id)->update(['default_address' => 0]);
            } else {
                Location::where('user_id', auth()->user()->id)->update(['default_address' => 0]);
                Location::where('id', $location_id)->update(['default_address' => 1]);
            }

            // return $this->sendResponse(new CartResource($add_to_cart), 'Add to cart list', 200);
            return $this->sendResponse([
                'cart' => new CartResource($add_to_cart),
             
            ], 'Add to cart list', 200);

        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }


    public function removeCartItem($id)
    {
        try {
            $cartItem = CartItem::find($id);

            if (!$cartItem) {
                return $this->sendError([], 'Item not found', 404);
            }

            $cart = $cartItem->cart;

            $cartItem->delete();

            $total_price = $cart->cartItems->sum(function ($cartItem) {
                return $cartItem->item_price * $cartItem->no_of_items;
            });

            if ($total_price == 0) {
                $cart->delete();
                return $this->sendResponse([], 'Cart is empty and has been deleted', 200);
            }

            $grant_total = $total_price + $cart->deliver_charges;

            $cart->update([
                'total_price' => $total_price,
                'grant_total' => $grant_total,
            ]);
            return $this->sendResponse([], 'Item removed successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function removeCart($id)
    {
        try {
            $cart = Cart::find($id);
            if ($cart) {
                if ($cart->cartItems) {
                    $cart->cartItems->each(function ($cartItem) {
                        $cartItem->delete();
                    });
                }
                $cart->delete();
            }
            return $this->sendResponse([], 'Cart Items removed successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function placeOrder(OrderRequest $request)
    {

        try {
            $existingOrder = Order::where('cart_id', $request->cart_id)->first();

            if ($existingOrder) {
                return $this->sendError([], 'An order already exists for this cart.', 400);
            }

            $minOrderValue = Minimum_order_value::first();
            $minimumOrder = $minOrderValue ? $minOrderValue->minimum_order_value : 100;
            $cart = Cart::find($request->cart_id);

            if ($cart?->category?->is_show == 0 && $cart->total_price < $minimumOrder) {
                return $this->sendError([], 'Minimum order value should be Rs.' . $minimumOrder . '.', 407);
            }
            $currentTime = now();
            $cutoffTime = $currentTime->copy()->setTime(17, 0, 0);

            if ($currentTime->greaterThan($cutoffTime)) {
                $deliveryDate = $currentTime->addDay()->toDateString();
            } else {
                $deliveryDate = $currentTime->toDateString();
            }

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'cart_id' => $request->cart_id ?? '',
                'order_id' => $this->generateOrderID(),
                'name' => $request->name ?? '',
                'phone_no' => $request->phone_no ?? '',
                'description' => $request->description ?? '',
                'address_to' => $request->address_to ?? '',
                'address_from' => $request->address_from ?? '',
                'property_address' => $request->property_address ?? '',
                'property_details' => $request->property_details ?? '',
                'expected_cost' => $request->expected_cost ?? '',
                'delivery_date' => $deliveryDate ?? '',
                'phone_company' => $request->phone_company ?? '',
                'phone_model' => $request->phone_model ?? '',
                'expected_rent' => $request->expected_rent ?? '',
                'preferred_location' => $request->preferred_location ?? '',
                'required_property_details' => $request->required_property_details ?? '',
                'date_of_journey' => $request->date_of_journey ?? null,
                'time_of_journey' => $request->time_of_journey ?? null,
                'approximate_load' => $request->approximate_load ?? '',
                'estimated_work_hours' => $request->estimated_work_hours ?? '',
                'no_of_passengers' => $request->no_of_passengers ?? '',
                'estimated_distance' => $request->estimated_distance ?? '',
                'total_orchard_area' => $request->total_orchard_area ?? '',
                'age_of_orchard' => $request->age_of_orchard ?? '',
                'type_of_fruit_plant' => $request->type_of_fruit_plant ?? '',
                'total_estimated_weight' => $request->total_estimated_weight ?? '',
                'expected_demanded_total_cost' => $request->expected_demanded_total_cost ?? '',
                'product_name_model' => $request->product_name_model ?? '',
                'month_year_of_purchase' => $request->month_year_of_purchase ?? '',
                'product_brand' => $request->product_brand ?? '',
                'expected_demanded_price' => $request->expected_demanded_price ?? '',
            ]);

            $cart = Cart::find($request->cart_id);
            if ($cart) {
                $cart->update([
                    'status' => 1
                ]);
            }

            $user = User::find(auth()->user()->id);
            FCMService::send(
                $user->device_token,
                [
                    'user_id' => $user->id,
                    'type' => 'order_placed',
                    'title' => 'Order placed successfully!',
                    'body' => 'Your order has been placed.',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                ]
            );
            event(new OrderPlacedEvent(auth()->user()->name));
            return $this->sendResponse($order, 'Order placed successfully', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function myOrders(Request $request)
    {
        try {
            $orders = Order::where('user_id', auth()->user()->id);
            if ($request->status == 'active') {
                $orders = $orders->whereIn('status', ['order_confirmed', 'order_packed', 'out_for_delivery', 'order_delivered']);
            }
            if ($request->status == 'completed') {
                $orders = $orders->where('status', 'payment_completed');
            }
            $orders = $orders->get();
            return $this->sendResponse(['orders' => OrderResource::collection($orders)], 'My orders list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function getOrderDetails($id)
    {
        try {
            $orders = Order::find($id);
            return $this->sendResponse(new OrderResource($orders), 'Order details', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    function generateOrderID()
    {
        $prefix = '#DBSV';

        $lastOrder = Order::latest('id')->first();

        if ($lastOrder) {
            preg_match('/(\d+)$/', $lastOrder->order_id, $matches);
            $incrementalPart = (int) $matches[0] + 1;
        } else {
            $incrementalPart = rand(100000, 999999);
        }

        $incrementalPart = str_pad($incrementalPart, 6, '0', STR_PAD_LEFT);

        return $prefix . $incrementalPart;
    }

    public function getDynamicFormFields(Request $request)
    {
        try {
            $manage_forms = ManageForm::with('manageFields')->where('category_id', $request->category_id)->first();
            return $this->sendResponse(new ManageFormResource($manage_forms), 'Dynamic form fields list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function searchFilter(Request $request)
    {
        try {
            $baseUrl = url('storage/product');
            $name = $request->name;

            $products = Product::with(['category', 'inventory'])
                ->where('title', 'like', '%' . $name . '%')
                ->active()
                ->get();

            if ($products->isEmpty()) {
                return $this->sendError(
                    [],
                    'No products found for the given search term',
                    404
                );
            }

            $formattedProducts = $products->map(function ($product) use ($baseUrl) {
                $itemArray = $product->toArray();

                if (ProductResource::isJson($product->image)) {
                    // Decode JSON string if the image field is JSON
                    $decodedImages = json_decode($product->image, true);
                    $imagesWithUrl = array_map(fn($img) => "{$baseUrl}/{$img}", $decodedImages);
                    $imageOutput = $decodedImages;
                } else {
                    // Treat the image as a single image if it's not JSON
                    $imageOutput = [$product->image];
                    $imagesWithUrl = [$baseUrl . '/' . $product->image];
                }

                // Add image and image_with_url to the item array
                $itemArray['image'] = $imageOutput;
                $itemArray['image_with_url'] = $imagesWithUrl;

                // Return the formatted product data
                return [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category->title ?? null,
                    'subcategory_id' => $product->subcategory_id,
                    'title' => $product->title,
                    'description' => $product->description,
                    'total_amount' => $product->total_amount,
                    'discount' => $product->discount,
                    'selling_price' => $product->selling_price,
                    'image' => $imageOutput,
                    'image_with_url' => $imagesWithUrl,
                    'out_of_stock' => $product->out_of_stock,
                    'status' => $product->status,
                    'order' => $product->order,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'inventory' => $product->inventory,
                ];
            });

            return $this->sendResponse(
                ['products' => $formattedProducts],
                'Products found successfully',
                200
            );
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function getDeliveryCharges()
    {
        try {
            $delivery_charges = DeliveryCharge::get();
            return $this->sendResponse($delivery_charges, 'Delivery charges list', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function addToCartCount()
    {
        try {
            $cart = Cart::withCount('cartItems')->where([
                'user_id' => auth()->user()->id,
                'status' => '0'
            ])->first();

            if ($cart) {
                $cartCount = $cart->cart_items_count;
            } else {
                $cartCount = 0;
            }

            return $this->sendResponse($cartCount, 'Cart items count', 200);
        } catch (\Exception $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
    }

    public function coupons()
    {
        try {
            // Fetch all coupons
            $coupons = Coupon::all();

            // Return success response with coupons data
            return response()->json([
                'success' => true,
                'data' => $coupons
            ], 200);
        } catch (\Exception $e) {
            // Return error response with exception message
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch coupons',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function productDetail($id)
    {
        try {
            $product = Product::with(['category', 'subcategory'])->find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $id) // Exclude the current product
                ->inRandomOrder()
                ->take(10)
                ->get();

            $relatedProductList = [];
            $baseUrl = url('storage/product');

            foreach ($relatedProducts as $item) {
                $itemArray = $item->toArray();

                if (ProductResource::isJson($item['image'])) { // $this->isJson($item['image']
                    $decodedImages = json_decode($item['image'], true);
                    $imagesWithUrl = array_map(fn($img) => "{$baseUrl}/{$img}", $decodedImages);
                    $imageOutput = json_encode($decodedImages, JSON_UNESCAPED_SLASHES);
                } else {
                    $imageOutput = [$item['image']];
                    $imagesWithUrl = [$baseUrl . '/' . $item['image']];
                }

                // dd($imagesWithUrl);
                $itemArray['image'] = $imageOutput;
                $itemArray['image_with_url'] = $imagesWithUrl;

                $relatedProductList[] = $itemArray;

            }


            return response()->json([
                'success' => true,
                'data' => [
                    'product' => new ProductResource($product),
                    'related_products' => $relatedProductList,
                ],
                'message' => 'Product details fetched successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product details',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function applyCoupon(Request $request)
    {
        try {
            $cart = Cart::find($request->cart_id);

            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart not found.',
                    'data' => null
                ], 404);
            }

            $total_price = $cart->total_price;
            $delivery_charge = $cart->deliver_charges;

            $coupon = Coupon::where([
                ['code', '=', $request->coupon_code],
                ['cat_id', '=', $cart->category_id]
            ])->first();

            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Coupon or expired.',
                    'data' => null
                ], 404);
            }

            $grant_total = $total_price + $delivery_charge;


            if ($coupon->status != 0 && Carbon::now()->lessThanOrEqualTo($coupon->expires_at)) {
                if ($request->coupon_code === $coupon->code) {
                    $discount = 0;
                    $discount_type = null;

                    if ($coupon->type == 'percentage') {
                        $discount = ($coupon->discount_value / 100) * $total_price;
                        $discount_type = 'percentage';
                    } elseif ($coupon->type == 'fixed') {
                        $discount = $coupon->discount_value;
                        $discount_type = 'fixed';
                    }

                    $deliver_charges = $cart->deliver_charges ?? 0;
                    $distance_charge = $cart->distance_charge ?? 0;

                    $grant_total = ($total_price - $discount) + $deliver_charges + $distance_charge;

                    $cart->update([
                        'total_price' => $total_price,
                        'grant_total' => $grant_total,
                        'coupon_id' => $coupon->id,
                        'discount' => $discount,
                        'discount_type' => $discount_type,
                        'coupon' => $discount_type,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Coupon applied successfully.',
                        'data' => [
                            'grant_total' => $grant_total,
                            'discount' => $discount,
                            'discount_type' => $discount_type,
                        ]
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Coupon.',
                    'data' => null
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => 'Coupon is either expired or inactive.',
                'data' => null
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while applying the coupon.',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}