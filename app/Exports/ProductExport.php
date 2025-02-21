<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Product Name',
            'Category',
            'Sub Category',
            'Actual Price',
            'Selling Price',
            'Out of Stock',
            'Status',
            'Created At'
        ];
    } 
    public function collection()
    {
        return Product::get()->map(function ($product) {
            return [
                'title' => $product->title,
                'category' => $product?->category?->title ?? '',
                'subcategory' => $product?->subcategory?->title ?? '',
                'total_amount' => $product->total_amount ?? '',
                'selling_price' => $product->selling_price ?? '',
                'out_of_stock' => isset($product->out_of_stock) && $product->out_of_stock == 1 ? 'True' : 'False',
                'status' => $product->status == 1 ? 'Active' : 'InActive',
                'created_at' => $product->created_at->toDateTimeString(),
            ];
        });
    }
}
