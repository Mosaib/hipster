    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

    Route::get('/', function () {
        return view('welcome');
    });
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
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
