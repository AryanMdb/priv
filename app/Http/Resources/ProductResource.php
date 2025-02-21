<?php

namespace App\Http\Resources;

use App\Models\CartItem;
use App\Models\Product;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{


    public static function correctImageFormat($data)
    {
        $baseUrl = url('storage/product');

        if (ProductResource::isJson($data)) {
            // Decode JSON string if the image field is JSON
            $decodedImages = json_decode($data, true);
            $imagesWithUrl = array_map(fn($img) => "{$baseUrl}/{$img}", $decodedImages);
            $imageOutput = $decodedImages;
        } else {
            // Treat the image as a single image if it's not JSON
            $imageOutput = [$data];
            $imagesWithUrl = [$baseUrl . '/' . $data];
        }

        return [$imagesWithUrl, $imageOutput];
    }


    public static function isJson($data)
    {
        json_decode($data, true);

        // Check for JSON errors
        return json_last_error() === JSON_ERROR_NONE;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $baseUrl = url('storage/product');
        $product = Product::with(['category', 'subcategory'])->find($this->id);
        $orderCount = CartItem::where('cart_items.product_id', $product->id)
            ->join('orders', 'cart_items.cart_id', '=', 'orders.cart_id')
            ->select('orders.id') // Select only unique order IDs
            ->distinct() // Ensure uniqueness
            ->count(); // Count unique orders

        $itemArray = $product->toArray();

        if ($this->isJson($product->image)) {
            $decodedImages = json_decode($product->image, true);
            $imagesWithUrl = array_map(fn($img) => "{$baseUrl}/{$img}", $decodedImages);
            $imageOutput = $decodedImages;
        } else {
            $imageOutput = [$product->image];
            $imagesWithUrl = [$baseUrl . '/' . $product->image];
        }

        $itemArray['image'] = $imageOutput;
        $itemArray['image_with_url'] = $imagesWithUrl;
        $discount = $this->discount ?? "";
        $sellingPrice = $this->selling_price ?? 0;
        $totalAmount = $this->total_amount ?? 0;
        
        if (($discount === null || $discount == 0 || $discount == "") && $sellingPrice > 0) {
            $discount = $totalAmount > 0 ? (($totalAmount - $sellingPrice) / $totalAmount) * 100 : "";
        }
        
        $discount = (float) $discount;
        $formatted_discount = $discount > 0 ? number_format($discount, 2, '.', '') : "";
        return [
            'id' => $this->id ?? '',
            'category' => $this?->category?->title ?? '',
            'category_id' => $this->category_id ?? '',
            'subcategory_id' => $this->subcategory_id ?? '',
            'subcategory' => $this?->subcategory?->title ?? '',
            'title' => $this->title ?? '',
            'total_amount' => $totalAmount,
            'discount' => $formatted_discount,
            'description' => $this->description ?? null,
            'selling_price' => $sellingPrice,
            'order_count' => $orderCount,
            'out_of_stock' => isset($this->out_of_stock) && $this->out_of_stock == 1 ? true : false,
            'image' => $imageOutput,
            'image_with_url' => $imagesWithUrl,
            'product_inventory' => $this->inventory ?? '',
            'subcategory_data' => $this->subcategory,
            'categories' => $this->category,

        ];
    }
}

