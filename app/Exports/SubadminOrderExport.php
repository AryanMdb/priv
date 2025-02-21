<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubadminOrderExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
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

    /**
     * Get the collection of orders to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->orders->map(function ($order) {
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
