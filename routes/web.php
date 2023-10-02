<?php


use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomerController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Branch
    Route::get('branches/list/trash', [BranchController::class, 'showTrash'])->name('branches.list.trash');
    Route::get('branches/restore/trash/{id}', [BranchController::class, 'restoreTrash'])->name('branches.restore.trash');
    Route::delete('branches/destroy', 'BranchController@massDestroy')->name('branches.massDestroy');
    Route::resource('branches', 'BranchController');

    // Products
    Route::get('products/export', [ProductsController::class, 'export'])->name('products.export');
    Route::get('products/list/trash', [ProductsController::class, 'showTrash'])->name('products.list.trash');
    Route::get('products/restore/trash/{id}', [ProductsController::class, 'restoreTrash'])->name('products.restore.trash');
    Route::get('products/search', [ProductsController::class, 'search'])->name('products.search');
    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');
    Route::post('products/add/stock', 'ProductsController@addStock')->name('products.add.stock');
    Route::get('products/inventory/{id}', 'ProductsController@showInventory')->name('products.inventory');
    Route::post('products/import', 'ProductsController@uploadProducts')->name('products.import');
    Route::resource('products', 'ProductsController');

    // Invoice
    Route::get('invoices/list/trash', [InvoiceController::class, 'showTrash'])->name('invoices.list.trash');
    Route::get('invoices/restore/trash/{id}', [InvoiceController::class, 'restoreTrash'])->name('invoices.restore.trash');
    Route::delete('invoices/destroy', 'InvoiceController@massDestroy')->name('invoices.massDestroy');
    Route::get('invoices/product/delete', 'InvoiceController@deleteProduct')->name('invoices.delete.product');
    Route::post('invoices/media', 'InvoiceController@storeMedia')->name('invoices.storeMedia');
    Route::resource('invoices', 'InvoiceController');
    Route::post('upload-codes', 'InvoiceController@uploadCodes')->name('invoices.upload');
    Route::get('employee/pdf/{id}', [InvoiceController::class, 'createPDF'])->name('invoice.pdf.download');
    Route::get('/export-site-informations', [InvoiceController::class, 'exportSiteInformations'])->name('export-site-informations');

    //ServiceType
    Route::resource('service-types', 'ServiceTypeController');

    // Township
    Route::resource('townships', 'TownshipController');

    //ServicePlan
    Route::resource('service_plans','ServicePlanController');

    // Customer
    Route::get('customers/export', 'CustomerController@export')->name('customers.export');
    Route::get('customer/info', [CustomerController::class, 'getInfo']);
    Route::get('customers/list/trash', [CustomerController::class, 'showTrash'])->name('customers.list.trash');
    Route::get('customers/restore/trash/{id}', [CustomerController::class, 'restoreTrash'])->name('customers.restore.trash');
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');
    Route::get('/export-customer-info', [CustomerController::class, 'export'])->name('export-customer-info');
    Route::post('/import-customer-info', [CustomerController::class, 'import'])->name('import-customer-info');
    Route::resource('customers', 'CustomerController');

    // Categories
    Route::get('categories/list/trash', [CategoriesController::class, 'showTrash'])->name('categories.list.trash');
    Route::get('categories/restore/trash/{id}', [CategoriesController::class, 'restoreTrash'])->name('categories.restore.trash');
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Customer Assign
    Route::delete('customer-assigns/destroy', 'CustomerAssignController@massDestroy')->name('customer-assigns.massDestroy');
    Route::resource('customer-assigns', 'CustomerAssignController');
    Route::get('customer-assigns/export/all-service', 'CustomerAssignController@allServiceExport')->name('export.all-service');
    Route::get('customer-assigns/export/suspend', 'CustomerAssignController@suspendExport')->name('export.suspend');
    Route::get('customer-assigns/export/completed', 'CustomerAssignController@completedExport')->name('export.completed');
    Route::get('customer-assigns/export/cancel', 'CustomerAssignController@cancelExport')->name('export.cancel');
    Route::get('customer-assigns/export/pending', 'CustomerAssignController@pendingExport')->name('export.pending');
    Route::get('customer-assigns/change/action/', 'CustomerAssignController@changeAction')->name('change.action');
    Route::get('customer-assigns/change/action/restore/{id}', 'CustomerAssignController@changeActionRestore')->name('change.action.restore');
    Route::get('customer-assigns/action/pending', 'CustomerAssignController@showPending')->name('customer.assign.pending');
    Route::get('customer-assigns/action/completed', 'CustomerAssignController@showCompleted')->name('customer.assign.completed');
    Route::get('customer-assigns/action/suspend', 'CustomerAssignController@showSuspend')->name('customer.assign.suspend');
    Route::get('customer-assigns/action/cancel', 'CustomerAssignController@showCancel')->name('customer.assign.cancel');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Expense Category
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Category
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Income
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Report
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::get('product/price/', [ProductsController::class, 'getPrice']);
Route::post('file-import', [ProductsController::class, 'fileImport'])->name('file-import');
