<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * Return the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Full Name',
            'Image',
            'Phone Number',
            'Gender',
            'Status',
            'Created At',
        ];
    }

    /**
     * Retrieve the user data collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('role', 'customer')
            ->whereNull('deleted_at')
            ->where('status', 1) // Only active users
            ->where('is_verified', 1) // Only verified users
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'image' => $user->image
                        ? asset("storage/profile_image/{$user->image}")
                        : asset("images/avatar.png"),
                    'phone' => $user->phone ?? '',
                    'gender' => $user->gender ?? '',
                    'status' => $user->status == 1 ? 'Active' : 'Inactive',
                    'created_at' => $user->created_at->toDateTimeString(),
                ];
            });
    }
}
