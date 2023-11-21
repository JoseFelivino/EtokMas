<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\GoldCaratCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookKeepingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PawnController;
use App\Http\Controllers\GoldTransactionHistoryController;
use App\Http\Controllers\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth', 'verified'])->group( function () { 
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/cashier', [CashierController::class,'index'])->name('cashier.index');
    Route::post('/cashier/checkout', [CashierController::class,'checkout'])->name('cashier.checkout');

    Route::get('/stock', [StockController::class,'index'])->name('stock.index');
    Route::post('/getStockById', [StockController::class,'searchStockByIdUsingAPIBasedRequest'])->name('stock.searchCustomerByNameUsingAPIBasedRequest');
    Route::get('/stock/create', [StockController::class,'create'])->name('stock.create');
    Route::get('/stock/{stock}', [StockController::class,'show'])->name('stock.show');
    Route::post('/stock', [StockController::class,'store'])->name('stock.store');
    Route::get('/stock/{stock}/edit', [StockController::class,'edit'])->name('stock.edit');
    Route::put('/stock/{stock}', [StockController::class,'update'])->name('stock.update');

    Route::get('/customer', [CustomerController::class,'index'])->name('customer.index');
    Route::post('/getCustomerByName', [CustomerController::class,'searchCustomerByNameUsingAPIBasedRequest'])->name('customer.searchCustomerByNameUsingAPIBasedRequest');
    Route::get('/customer/create', [CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer', [CustomerController::class,'store'])->name('customer.store');
    Route::post('/customer/storeUsingAPIBasedRequest', [CustomerController::class,'storeUsingAPIBasedRequest'])->name('customer.storeUsingAPIBasedRequest');
    Route::get('/customer/{customer}/edit', [CustomerController::class,'edit'])->name('customer.edit');
    Route::put('/customer/{customer}', [CustomerController::class,'update'])->name('customer.update');

    Route::get('/notification', [NotificationController::class,'index'])->name('notification.index');
    Route::get('/isHasUnreadNotification', [NotificationController::class,'isHasUnreadNotification'])->name('notification.isHasUnreadNotification');
    Route::put('/markAsRead/{notification}', [NotificationController::class,'markAsRead'])->name('notification.markAsRead');
    Route::put('/markAllUnreadNotificationsAsRead', [NotificationController::class,'markAllUnreadNotificationsAsRead'])->name('notification.markAllUnreadNotificationsAsRead');
    Route::delete('/notification/{notification}', [NotificationController::class,'destroy'])->name('notification.destroy');
    Route::delete('/destroyAllUnreadNotifications', [NotificationController::class,'destroyAllUnreadNotifications'])->name('notification.destroyAllUnreadNotifications');
    Route::delete('/destroyAllReadNotifications', [NotificationController::class,'destroyAllReadNotifications'])->name('notification.destroyAllReadNotifications');
    
    Route::get('/pawn', [PawnController::class,'index'])->name('pawn.index');
    Route::post('/getPawnTransactionByFilter', [PawnController::class,'searchTransactionByFilterUsingAPIBasedRequest'])->name('pawn.searchTransactionByFilterUsingAPIBasedRequest');
    Route::get('/checkForUpcomingPawnAndPushNotif', [PawnController::class,'checkForUpcomingPawnAndPushNotif'])->name('pawn.checkForUpcomingPawnAndPushNotif');
    Route::get('/pawn/create', [PawnController::class,'create'])->name('pawn.create');

    Route::get('/changePassword', [ChangePasswordController::class,'index'])->name('changePassword.index');
    Route::put('/changePassword/update', [ChangePasswordController::class,'update'])->name('changePassword.update');

    Route::get('/goldTransactionHistory', [GoldTransactionHistoryController::class,'index'])->name('goldTransactionHistory.index');
    Route::get('/goldTransactionHistory/{transactionHeader}', [GoldTransactionHistoryController::class,'show'])->name('goldTransactionHistory.show');
    Route::get('/pawn/{pawnTransactionHeader}', [PawnController::class,'show'])->name('pawn.show');
    Route::middleware(['role:admin'])->group( function () { 
        Route::delete('/customer/{customer}', [CustomerController::class,'destroy'])->name('customer.destroy');
        Route::delete('/stock/{stock}', [StockController::class,'destroy'])->name('stock.destroy');

        Route::get('/goldCarat', [GoldCaratCategoryController::class,'index'])->name('goldCarat.index');
        Route::get('/goldCarat/create', [GoldCaratCategoryController::class,'create'])->name('goldCarat.create');
        Route::post('/goldCarat', [GoldCaratCategoryController::class,'store'])->name('goldCarat.store');
        Route::get('/goldCarat/{goldCaratCategory}/edit', [GoldCaratCategoryController::class,'edit'])->name('goldCarat.edit');
        Route::put('/goldCarat/{goldCaratCategory}', [GoldCaratCategoryController::class,'update'])->name('goldCarat.update');
        Route::delete('/goldCarat/{goldCaratCategory}', [GoldCaratCategoryController::class,'destroy'])->name('goldCarat.destroy');

        Route::get('/shelf', [ShelfController::class,'index'])->name('shelf.index');
        Route::get('/shelf/create', [ShelfController::class,'create'])->name('shelf.create');
        Route::post('/shelf', [ShelfController::class,'store'])->name('shelf.store');
        Route::get('/shelf/{shelf}/edit', [ShelfController::class,'edit'])->name('shelf.edit');
        Route::put('/shelf/{shelf}', [ShelfController::class,'update'])->name('shelf.update');
        Route::delete('/shelf/{shelf}', [ShelfController::class,'destroy'])->name('shelf.destroy');

        Route::get('/category', [CategoryController::class,'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class,'create'])->name('category.create');
        Route::post('/category', [CategoryController::class,'store'])->name('category.store');
        Route::get('/category/{category}/edit', [CategoryController::class,'edit'])->name('category.edit');
        Route::put('/category/{category}', [CategoryController::class,'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class,'destroy'])->name('category.destroy');

        Route::get('/bookkeeping', [BookKeepingController::class,'index'])->name('bookkeeping.index');
        Route::get('/bookkeeping/{shelf}', [BookKeepingController::class,'show'])->name('bookkeeping.show');
        Route::get('/bookkeepingDetail/{bookKeepingHeader}', [BookKeepingController::class,'showBookKeepingDetail'])->name('bookkeeping.showBookKeepingDetail');
        Route::get('/bookkeeping/{shelfId}/create', [BookKeepingController::class,'create'])->name('bookkeeping.create');
        Route::post('/bookkeeping', [BookKeepingController::class,'store'])->name('bookkeeping.store');

        Route::get('/employee', [EmployeeController::class,'index'])->name('employee.index');
        Route::get('/employee/{employee}/edit', [EmployeeController::class,'edit'])->name('employee.edit');
        Route::put('/employee/{employee}', [EmployeeController::class,'update'])->name('employee.update');
        Route::delete('/employee/{employee}', [EmployeeController::class,'destroy'])->name('employee.destroy');

        Route::get('/pawn/{pawnTransactionHeader}/edit', [PawnController::class,'edit'])->name('pawn.edit');
        Route::put('/pawn/{pawnTransactionHeader}', [PawnController::class,'update'])->name('pawn.update');
        Route::post('/pawn', [PawnController::class,'store'])->name('pawn.store');
        Route::delete('/pawn/{pawnTransactionHeader}', [PawnController::class,'destroy'])->name('pawn.destroy');
        Route::get('/pawn/{pawnTransactionHeader}/showPawnTransactionHeaderAsDonePage', [PawnController::class,'showPawnTransactionHeaderAsDonePage'])->name('pawn.showPawnTransactionHeaderAsDonePage');
        Route::put('/markPawnTransactionHeaderAsDone/{pawnTransactionHeader}', [PawnController::class,'markPawnTransactionHeaderAsDone'])->name('pawn.markPawnTransactionHeaderAsDone');
        Route::get('/pawn/{pawnTransactionHeader}/showPawnTransactionHeaderAsUnDonePage', [PawnController::class,'showPawnTransactionHeaderAsUnDonePage'])->name('pawn.showPawnTransactionHeaderAsUnDonePage');
        Route::put('/markPawnTransactionHeaderAsUnDone/{pawnTransactionHeader}', [PawnController::class,'markPawnTransactionHeaderAsUnDone'])->name('pawn.markPawnTransactionHeaderAsUnDone');
    });

});





require __DIR__.'/auth.php';
