    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\ProductController;


    Route::get('/', function () {
        return view('welcome');
    });
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        //product
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    });


    // Customer routes
    Route::prefix('customer')->name('customer.')->middleware('auth:customer')->group(function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('dashboard');
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

    require __DIR__.'/auth.php';
