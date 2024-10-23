<?php

declare(strict_types=1);

use App\Imports\OORImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SKUController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\TouchpointController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EscalationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngestionController;
use App\Http\Controllers\FinishedPartsController;
use App\Http\Controllers\EmailController;
use Inertia\Inertia;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    /*
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    */
    //Route::get('/', [HomeController::class, 'index'])->name('home.tenant');


    Route::get('/create-role', function(){
        //$role = \Spatie\Permission\Models\Role::findByName('manager');
        //$permission = \Spatie\Permission\Models\Permission::find(2);
        //$permission->assignRole($role);
        return false;
    });

    Route::middleware('auth')->group(function () {
        Route::middleware('can:viewAny, App\Models\Touchpoint')->group(function(){
            Route::prefix('admin')->group(function(){
                Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
                Route::get('/users/create', [UserController::class, 'create'])->name('admin.user.create');
                Route::post('/users/store', [UserController::class, 'store']);
                Route::get('/user/{user_id}', [UserController::class, 'show'])->name('admin.users.show');
                Route::post('/users/update', [UserController::class, 'update']);
                Route::post('/user/updaterole', [UserController::class, 'updaterole']);

                Route::get('/supplier/scores', [SupplierController::class, 'adminSupplierScores'])->name('admin.supplier.scores');
                Route::get('/supplier/{supplier}/scores', [SupplierController::class, 'adminSupplierScore'])->name('admin.supplier.score');

                Route::get('/touchpoints', [TouchpointController::class, 'index'])->name('admin.touchpoints.index');
                Route::get('/touchpoint/create', [TouchpointController::class, 'create'])->name('admin.touchpoint.create');
                Route::post('/touchpoint/store', [TouchpointController::class, 'store']);
                Route::get('/touchpoint/{touchpoint_id}', [TouchpointController::class, 'show'])->name('admin.touchpoint.show');
                Route::get('/touchpoint/{touchpoint_id}/edit', [TouchpointController::class, 'edit'])->name('admin.touchpoint.edit');
            });
        });

        Route::post('/addComment', [LineController::class, 'addComment']);
        Route::post('/addToFinishedPart', [FinishedPartsController::class, 'addSku']);
        Route::get('/command', function(){
            //Artisan::call("import:oor", ["filename"=>"NPI Report-CA 202410070810269101.xlsx"]);
            //Artisan::call('app:create-test-suppliers');
            //Artisan::call("app:give-suppliers100");
            //Artisan::call('app:simulateActivityDates');
            //return \Illuminate\Support\Facades\Hash::make('abcd.1234');
            //return (new \App\Exports\RandomOORExport)->download('oor.xlsx');
            return false;
        });

        Route::get('/command/resetDatabase', function(){
            Artisan::call("app:reset-database");

            $tenant = tenant('id');
            $x = storage_path();
            Excel::import(new OORImport, storage_path('app/data/oor_'.$tenant.'.xlsx'));

            Artisan::call("app:give-suppliers100");

            \App\Models\Escalation::EscalateSuppliers();
            return to_route("suppliers");
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

        Route::get('/dashboard2', function(){
            return Inertia::render('Dashboard2');
        })->name('dashboard2');

        Route::post('/delete/contact', [ContactController::class, 'deleteContact']);

        Route::post('/addTaskComment', [EscalationController::class, 'addTaskComment']);
        Route::post('/getTaskComments', [EscalationController::class, 'getTaskComments']);
        Route::post('/updateTaskStatus', [EscalationController::class, 'updateTaskStatus']);

        Route::get('/emails/weeklyupdate', [EmailController::class, 'weeklyupdate']);
        Route::get('/emails/dataingested', [EmailController::class, 'dataIngested']);
        Route::get('/emails/supplierrequest/{supplier_id}', [EmailController::class, 'supplierRequest']);

        Route::get('/escalations', [EscalationController::class, 'index'])->name('escalations');
        Route::get('/escalation/{supplier_id}', [EscalationController::class, 'show'])->name('escalation.supplier');
        Route::get('/escalation/{escalation_id}/{identifier}', [EscalationController::class, 'showLine'])->name('escalation.line');

        Route::get('/generateOOR', [IngestionController::class, 'generateOOR']);
        Route::post('/generateSupplierInfo', [SupplierController::class, 'generateSupplierInfo']);

        Route::get('/finishedparts', [FinishedPartsController::class, 'index'])->name('finishedparts');
        Route::get('/finishedparts/{id}', [FinishedPartsController::class, 'show'])->name('finishedparts.show');
        Route::post('/finishedpart', [FinishedPartsController::class, 'store']);
        Route::post('/finishedpart/removesku', [FinishedPartsController::class, 'removesku']);
        Route::get('/ingestions', [IngestionController::class, 'index'])->name('ingestions');

        Route::post('/map-column', [ColumnController::class, 'mapcolumn']);
        Route::get('/map-columns', [ColumnController::class, 'mapcolumns'])->name('map-columns');
        Route::post('/map-column-supplier', [ColumnController::class, 'mapcolumnssupplier']);

        Route::post('/meeting/add/input', [MeetingController::class, 'addInput']);
        Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings');
        Route::get('/meeting/{meeting_id}', [MeetingController::class, 'show'])->name('meeting.show');

        Route::get('/parts', [SKUController::class, 'index'])->name('parts');
        Route::get('/part/{part_id}', [SKUController::class, 'show'])->name('part.show');

        Route::get('/plants', [PlantController::class, 'index'])->name('plants');

        Route::post('/save/company/info', [SupplierController::class, 'saveInfo']);
        Route::post('/save/company/plant', [SupplierController::class, 'savePlant']);
        Route::post('/save/company/contact', [SupplierController::class, 'saveContact']);

        Route::post('/save/supplier', [SupplierController::class, 'saveSupplier']);
        Route::post('/save/plant', [PlantController::class, 'store']);

        Route::post('/saveLineActivity', [LineController::class, 'saveLineActivity']);
        Route::post('/saveLineDelayedReason', [LineController::class, 'saveLineDelayedReason']);

        Route::post('/search', [LineController::class, 'search']);

        Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers');
        Route::post('/supplier/upload', [LineController::class, 'uploadSupplierOOR']);
        Route::get('/supplier/mapcolumns', [SupplierController::class, 'mapcolumns'])->name('supplier.mapcolumns');
        Route::get('/supplier/{slug}', [SupplierController::class, 'show'])->name('supplier.show');
        Route::get('/supplier/{slug}/openorders', [SupplierController::class, 'lines'])->name('supplier.openorders');
        Route::get('/supplier/{slug}/company', [SupplierController::class, 'company'])->name('supplier.company');
        Route::get('/supplier/{slug}/network', [SupplierController::class, 'network'])->name('supplier.network');
        Route::get('/supplier/{slug}/activity', [SupplierController::class, 'activity'])->name('supplier.activity');
        Route::get('/supplier/{slug}/score', [SupplierController::class, 'network'])->name('supplier.score');

        Route::get('/supplier/{slug}/export', [SupplierController::class, 'exportlines'])->name('supplier.exportlines');
        Route::get('/supplier/{slug}/{identifier}', [LineController::class, 'showIdentifier'])->name('line.show.identifier');
        Route::get('/supplier/{slug}/{po}/{sku}/{line_id}', [LineController::class, 'show'])->name('line.show');
        Route::get('/supplier/ferguson', function(){
            return Inertia::render('Suppliers/Show');
        })->name('supplier-show');

        Route::get('/supplier/ferguson/score', function(){
            return Inertia::render('Suppliers/Score');
        })->name('supplier-score');

        Route::get('/supplier/ferguson/{po}', function(){
            return Inertia::render('Suppliers/PO');
        })->name('supplier-po');

        Route::get('/tracker', function(){
            return Inertia::render('Tracker');
        })->name('tracker');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/order/{order_id}', [OrderController::class, 'show'])->name('order.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/import', [ImportController::class, 'import'])->name('import');
        Route::get('/export', [LineController::class, 'export'])->name('export');
        Route::get('/phpinfo', function(){return phpinfo();});

        Route::post('/getTracking', [LineController::class, 'getTracking']);
        Route::post('/saveCommit', [LineController::class, 'saveCommit']);

        Route::post('/undoIngestion', [IngestionController::class, 'undoIngestion']);

        Route::get('/updatesupplierscore', [IngestionController::class, 'updateSupplierScores']);

        Route::post('/upload', [LineController::class, 'upload']);
        Route::post('/upload/partImage', [SkuController::class, 'uploadPartImage']);
    });


    require __DIR__.'/auth.php';

});
