    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;

    Route::get('/', function () {
        return view('welcome');
    });
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin', 'online'])->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        //product
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/download-csv', [ProductController::class, 'downloadCsv'])->name('products.downloadCsv');
        Route::post('import', [ProductController::class, 'import'])->name('products.import');


        //order
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::put('/orders/{id}', [OrderController::class, 'updateOrder'])->name('order.update');

        //User
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
    });


    // Customer routes
    Route::prefix('customer')->name('customer.')->middleware(['auth:customer', 'customer', 'online'])->group(function () {
        Route::get('/dashboard', fn() => view('customer.dashboard'))->name('dashboard');

        //product
        Route::get('/products', [ProductController::class, 'getByCustomer'])->name('products.index');
        //order
        Route::post('/orders/{productId}', [OrderController::class, 'placeOrderByCustomer'])->name('orders.store');
        Route::get('/orders', [OrderController::class, 'getByCustomerOrders'])->name('orders.index');
    });

    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user && $user->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user && $user->user_type === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        return redirect('/');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['auth:admin,customer'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

    require __DIR__.'/auth.php';
