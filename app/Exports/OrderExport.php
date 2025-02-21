<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Order ID',
            'Category',
            'Name',
            'Phone Number',
            'Property Details',
            'Expected Cost',
            'Grand Total Amount',
            'Status',
            'Created At'
        ];
    } 
    public function collection()
    {
        return Order::get()->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'category' => $order?->cart?->category?->title ?? '',
                'name' => $order->name ?? '',
                'phone_no' => $order->phone_no ?? '',
                'property_details' => $order->property_details ?? '',
                'expected_cost' => $order->expected_cost ?? '',
                'grant_total' => $order?->cart?->grant_total ?? '',
                'status' => $order->status == 1 ? 'Completed' : 'Active',
                'created_at' => $order->created_at->toDateTimeString(),
            ];
        });
    }
}
