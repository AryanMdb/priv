<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['main' => 'Manage Users',
             'name' => 'Manage Users'
            ],
            ['main' => 'Manage Users',
            'name' => 'Edit Users'
            ],
            ['main' => 'Manage Users',
            'name' => 'Delete Users'
            ],
            ['main' => 'Category Manage',
            'name' => 'Category'
            ],
            ['main' => 'Category Manage',
            'name' => 'Edit Category'
            ],
            ['main' => 'Category Manage',
            'name' => 'Delete Category'
            ],
            ['main' => 'Category Manage',
            'name' => 'Add Category'
            ],
            ['main' => 'Category Manage',
            'name' => 'Subcategory'
            ],
            ['main' => 'Category Manage',
            'name' => 'Edit Subcategory'
            ],
            ['main' => 'Category Manage',
            'name' => 'Delete Subcategory'
            ],
            ['main' => 'Category Manage',
            'name' => 'Add Subcategory'
            ],
            ['main' => 'Product Manage',
            'name' => 'Product Manage'
            ],
            ['main' => 'Product Manage',
            'name' => 'Edit Product'
            ],
            ['main' => 'Product Manage',
            'name' => 'Delete Product'
            ],
            ['main' => 'Product Manage',
            'name' => 'Add Product'
            ],
            ['main' => 'Roles Manage',
            'name' => 'Roles Manage'
            ],
            ['main' => 'Roles Manage',
            'name' => 'Edit Roles'
            ],
            ['main' => 'Roles Manage',
            'name' => 'Delete Roles'
            ],
            ['main' => 'Roles Manage',
            'name' => 'Add Roles'
            ],
            ['main' => 'Subadmin Manage',
            'name' => 'Subadmin Manage'
            ],
            ['main' => 'Subadmin Manage',
            'name' => 'Edit Subadmin'
            ],
            ['main' => 'Subadmin Manage',
            'name' => 'Delete Subadmin'
            ],
            ['main' => 'Subadmin Manage',
            'name' => 'Add Subadmin'
            ],
            ['main' => 'CMS Manage',
            'name' => 'CMS Manage'
            ],
            ['main' => 'CMS Manage',
            'name' => 'Edit CMS'
            ],
            ['main' => 'CMS Manage',
            'name' => 'Delete CMS'
            ],
            ['main' => 'CMS Manage',
            'name' => 'Add CMS'
            ],
            ['main' => 'FAQ Manage',
            'name' => 'FAQ Manage'
            ],
            ['main' => 'FAQ Manage',
            'name' => 'Edit FAQ'
            ],
            ['main' => 'FAQ Manage',
            'name' => 'Delete FAQ'
            ],
            ['main' => 'FAQ Manage',
            'name' => 'Add FAQ'
            ],
            ['main' => 'Slider Manage',
            'name' => 'Slider Manage'
            ],
            ['main' => 'Slider Manage',
            'name' => 'Edit Slider'
            ],
            ['main' => 'Slider Manage',
            'name' => 'Delete Slider'
            ],
            ['main' => 'Slider Manage',
            'name' => 'Add Slider'
            ],
            ['main' => 'Push Notifications',
            'name' => 'Push Notifications'
            ],
            ['main' => 'Push Notifications',
            'name' => 'Edit Push Notifications'
            ],
            ['main' => 'Push Notifications',
            'name' => 'Delete Push Notifications'
            ],
            ['main' => 'Push Notifications',
            'name' => 'Add Push Notifications'
            ],
            ['main' => 'Form Manage',
            'name' => 'Manage Form'
            ],
            ['main' => 'Form Manage',
            'name' => 'Edit Form'
            ],
            ['main' => 'Form Manage',
            'name' => 'Delete Form'
            ],
            ['main' => 'Form Manage',
            'name' => 'Add Form'
            ],
            ['main' => 'Order Manage',
            'name' => 'Order Manage'
            ],
            ['main' => 'Order Manage',
            'name' => 'View Order'
            ],
            ['main' => 'Enquiry Manage',
            'name' => 'Enquiry Manage'
            ],
            ['main' => 'Enquiry Manage',
            'name' => 'View Enquiry'
            ],
            ['main' => 'Delivery Charges',
            'name' => 'Delivery Charges'
            ],

        ];

        foreach ($permissions as $permissionData) {
            $slug = strtolower(str_replace(' ', '_', $permissionData['name']));
            Permission::create([
                'main' =>$permissionData['main'],
                'name' => $permissionData['name'],
                'guard_name' => 'web',
                'slug' => $slug,
            ]);
        }

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
