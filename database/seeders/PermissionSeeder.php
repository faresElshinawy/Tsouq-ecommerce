<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role all',
            'role create',
            'role edit',
            'role delete',


            'user all',
            'user create',
            'user edit',
            'user delete',
            'user order',
            'user address',
            'user wishlist',
            // 'user creditcard',
            // 'user creditcard delete',
            'user address all',
            'user address edit',
            'user address delete',
            'subscriber all',
            'subscriber delete',

            'refund all',
            'set refund',



            'order all',
            'order create',
            'order edit',
            'order delete',


            'category all',
            'category create',
            'category edit',
            'category delete',


            'color all',
            'color create',
            'color edit',
            'color delete',

            'size all',
            'size create',
            'size edit',
            'size delete',

            'products section',
            'products myProducts',
            'products all',
            'product status',
            'products create',
            'products edit',
            'products delete',
            'products rate',
            'products rate delete',
            'product-image all',
            'product-image create',
            'product-image delete',



            'feedbacks all',
            'feedbacks delete',

            'wishlist all',
            'wishlist create',
            'wishlist edit',
            'wishlist delete',
            'wishlist item',


            'voucher all',
            'voucher create',
            'voucher edit',
            'voucher delete',



            'brands all',
            'brands create',
            'brands edit',
            'brands delete',



            'city all',
            'city create',
            'city edit',
            'city delete',


            'country all',
            'country create',
            'country edit',
            'country delete',

            'settings edit',


            'user permission',

            'locations all',

            'address edit',

            'access dashboard',

            'notify',

            'customer service',

            'chat all',

            'delete reviews'

            ];
            foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            }


    }
}
