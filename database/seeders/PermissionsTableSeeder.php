<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'branch_create',
            ],
            [
                'id'    => 18,
                'title' => 'branch_edit',
            ],
            [
                'id'    => 19,
                'title' => 'branch_show',
            ],
            [
                'id'    => 20,
                'title' => 'branch_delete',
            ],
            [
                'id'    => 21,
                'title' => 'branch_access',
            ],
            [
                'id'    => 22,
                'title' => 'product_create',
            ],
            [
                'id'    => 23,
                'title' => 'product_edit',
            ],
            [
                'id'    => 24,
                'title' => 'product_show',
            ],
            [
                'id'    => 25,
                'title' => 'product_delete',
            ],
            [
                'id'    => 26,
                'title' => 'product_access',
            ],
            [
                'id'    => 27,
                'title' => 'invoice_create',
            ],
            [
                'id'    => 28,
                'title' => 'invoice_edit',
            ],
            [
                'id'    => 29,
                'title' => 'invoice_show',
            ],
            [
                'id'    => 30,
                'title' => 'invoice_delete',
            ],
            [
                'id'    => 31,
                'title' => 'invoice_access',
            ],
            [
                'id'    => 32,
                'title' => 'customer_create',
            ],
            [
                'id'    => 33,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 34,
                'title' => 'customer_show',
            ],
            [
                'id'    => 35,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 36,
                'title' => 'customer_access',
            ],
            [
                'id'    => 37,
                'title' => 'category_create',
            ],
            [
                'id'    => 38,
                'title' => 'category_edit',
            ],
            [
                'id'    => 39,
                'title' => 'category_show',
            ],
            [
                'id'    => 40,
                'title' => 'category_delete',
            ],
            [
                'id'    => 41,
                'title' => 'category_access',
            ],
            [
                'id'    => 42,
                'title' => 'customer_assign_create',
            ],
            [
                'id'    => 43,
                'title' => 'customer_assign_edit',
            ],
            [
                'id'    => 44,
                'title' => 'customer_assign_show',
            ],
            [
                'id'    => 45,
                'title' => 'customer_assign_delete',
            ],
            [
                'id'    => 46,
                'title' => 'customer_assign_access',
            ],
            [
                'id'    => 47,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 48,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 49,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 50,
                'title' => 'customer_assign_complete',
            ],
            [
                'id'    => 51,
                'title' => 'customer_assign_suspend',
            ],
            [
                'id'    => 52,
                'title' => 'expense_management_access',
            ],
            [
                'id'    => 53,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 54,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 55,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 56,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 57,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 58,
                'title' => 'income_category_create',
            ],
            [
                'id'    => 59,
                'title' => 'income_category_edit',
            ],
            [
                'id'    => 60,
                'title' => 'income_category_show',
            ],
            [
                'id'    => 61,
                'title' => 'income_category_delete',
            ],
            [
                'id'    => 62,
                'title' => 'income_category_access',
            ],
            [
                'id'    => 63,
                'title' => 'expense_create',
            ],
            [
                'id'    => 64,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 65,
                'title' => 'expense_show',
            ],
            [
                'id'    => 66,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 67,
                'title' => 'expense_access',
            ],
            [
                'id'    => 68,
                'title' => 'income_create',
            ],
            [
                'id'    => 69,
                'title' => 'income_edit',
            ],
            [
                'id'    => 70,
                'title' => 'income_show',
            ],
            [
                'id'    => 71,
                'title' => 'income_delete',
            ],
            [
                'id'    => 72,
                'title' => 'income_access',
            ],
            [
                'id'    => 73,
                'title' => 'expense_report_create',
            ],
            [
                'id'    => 74,
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => 75,
                'title' => 'expense_report_show',
            ],
            [
                'id'    => 76,
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => 77,
                'title' => 'expense_report_access',
            ],
            [
                'id'    => 78,
                'title' => 'inventory_access',
            ],
            [
                'id'    => 79,
                'title' => 'customer_assign_cancel',
            ],
            [
                'id'    => 80,
                'title' => 'customer_assign_pending',
            ],
            [
                'id'    => 81,
                'title' => 'service_type_access',
            ],
            [
                'id'    => 82,
                'title' => 'service_type_create',
            ],
            [
                'id'    => 83,
                'title' => 'service_type_edit',
            ],
            [
                'id'    => 84,
                'title' => 'service_type_show',
            ],
            [
                'id'    => 85,
                'title' => 'service_type_delete',
            ],
            [
                'id'    => 86,
                'title' => 'township_access',
            ],
            [
                'id'    => 87,
                'title' => 'township_create',
            ],
            [
                'id'    => 88,
                'title' => 'township_show',
            ],
            [
                'id'    => 89,
                'title' => 'township_edit',
            ],
            [
                'id'    => 90,
                'title' => 'township_delete',
            ],
            [
                'id'    => 91,
                'title' => 'service_plan_access',
            ],
            [
                'id'    => 92,
                'title' => 'service_plan_create',
            ],
            [
                'id'    => 93,
                'title' => 'service_plan_show',
            ],
            [
                'id'    => 94,
                'title' => 'service_plan_edit',
            ],
            [
                'id'    => 95,
                'title' => 'service_plan_delete',
            ],


        ];

        Permission::insert($permissions);
    }
}
