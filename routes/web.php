    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\AuthenticateController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\HomeProductController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\BrandController;
    use App\Http\Controllers\ReviewController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\MenuController;

    use App\Http\Controllers\FoodsController;
    use App\Http\Controllers\PostsController;
    use Illuminate\Support\Facades\Session;

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
    Route::get("/login",[AuthenticateController::class, 'login'])
            ->name('login');
    Route::post("/checkLogin",[AuthenticateController::class, 'checkLogin'])
        ->name('checkLogin');
    Route::post("/logout",[AuthenticateController::class, 'logout'])
        ->name('logout');


    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('', [AdminController::class, 'index'])
            ->name('admin');
        Route::get('search', [AdminController::class, 'search'])
            ->name('admin.search');
        Route::prefix('categories')->group(function () {
            Route::get('/search', [CategoryController::class, 'search'])
                ->name('categories.search');
            Route::get('/delete{id}', [CategoryController::class, 'delete'])
                ->name('categories.delete');
            Route::put('/update{id}', [CategoryController::class, 'update'])
                ->name('categories.update');
            Route::get('/edit{id}', [CategoryController::class, 'edit'])
                ->name('categories.edit');
            Route::post('/store', [CategoryController::class, 'store'])
                ->name('categories.store');
            Route::get('/create', [CategoryController::class, 'create'])
                ->name('categories.create');
            Route::put('/restore', [CategoryController::class, 'restore'])
                ->name('categories.restore');
            Route::get('/', [CategoryController::class, 'index'])
                ->name('categories');
        });
        Route::prefix('brands')->group(function () {
            Route::get('/search', [BrandController::class, 'search'])
                ->name('brands.search');
            Route::put('/restore', [BrandController::class, 'restore'])
                ->name('brands.restore');
            Route::get('/delete{id}', [BrandController::class, 'delete'])
                ->name('brands.delete');
            Route::put('/update{id}', [BrandController::class, 'update'])
                ->name('brands.update');
            Route::get('/edit{id}', [BrandController::class, 'edit'])
                ->name('brands.edit');
            Route::post('/store', [BrandController::class, 'store'])
                ->name('brands.store');
            Route::get('/create', [BrandController::class, 'create'])
                ->name('brands.create');
            Route::get('/', [BrandController::class, 'index'])
                ->name('brands');
        });

        Route::prefix('menus')->group(function () {
            Route::get('/delete{id}', [MenuController::class, 'delete'])
                ->name('menus.delete');
            Route::put('/update{id}', [MenuController::class, 'update'])
                ->name('menus.update');
            Route::get('/edit{id}', [MenuController::class, 'edit'])
                ->name('menus.edit');
            Route::post('/store', [MenuController::class, 'store'])
                ->name('menus.store');
            Route::get('/create', [MenuController::class, 'create'])
                ->name('menus.create');
            Route::get('/', [MenuController::class, 'index'])
                ->name('menus');
        });

        Route::prefix('products')->group(function () {
            Route::get('/search', [ProductController::class, 'search'])
                ->name('products.search');
            Route::put('/restore', [ProductController::class, 'restore'])
                ->name('products.restore');
            Route::get('/delete{id}', [ProductController::class, 'delete'])
                ->name('products.delete');
            Route::put('/update{id}', [ProductController::class, 'update'])
                ->name('products.update');
            Route::get('/fetch-quantity', [ProductController::class, 'fetchQuantity'])
                ->name('products.fetch-quantity');
            Route::get('/edit{id}', [ProductController::class, 'edit'])
                ->name('products.edit');
            Route::post('/store', [ProductController::class, 'store'])
                ->name('products.store');
            Route::get('/create', [ProductController::class, 'create'])
                ->name('products.create');
            Route::get('/', [ProductController::class, 'index'])
                ->name('products');
        });

        Route::prefix('orders')->group(function () {
            Route::get('/search', [OrderController::class, 'search'])
                ->name('orders.search');// route name luôn phải ở dạng orders.abcxyz để search box hướng url về phần trước dầu. tức orders và chấm thêm search
            Route::put('/restore', [OrderController::class, 'restore'])
                ->name('orders.restore');
            Route::get('/delete{id}', [OrderController::class, 'delete'])
                ->name('orders.delete');
            Route::post('/updateDelivery', [OrderController::class, 'updateDelivery'])
                ->name('orders.updateDelivery');
            Route::get('/getOrderNote', [OrderController::class, 'getOrderNote'])
                ->name('orders.getOrderNote');
            Route::post('/updateStaffNote', [OrderController::class, 'updateStaffNote'])
                ->name('orders.updateStaffNote');
            Route::get('/getStaffNote', [OrderController::class, 'getStaffNote'])
                ->name('orders.getStaffNote');
            Route::post('/updateOrderCancelReason', [OrderController::class, 'updateOrderCancelReason'])
                ->name('orders.updateOrderCancelReason');
            Route::get('/getOrderCancelReason', [OrderController::class, 'getOrderCancelReason'])
                ->name('orders.getOrderCancelReason');
            Route::get('/editOrderInfo', [OrderController::class, 'editOrderInfo'])
                ->name('orders.editOrderInfo');
            Route::get('/addDelivery', [OrderController::class, 'addDelivery'])
                ->name('orders.addDelivery');
            Route::get('/orderDetails', [OrderController::class, 'orderDetails'])
                ->name('orders.orderDetails');
            Route::put('/updateDeliveryFee', [OrderController::class, 'updateDeliveryFee'])
                ->name('orders.updateDeliveryFee');
            Route::put('/updateOrderStatus', [OrderController::class, 'updateOrderStatus'])
                ->name('orders.updateOrderStatus');
            Route::put('/updatePaymentStatus', [OrderController::class, 'updatePaymentStatus'])
                ->name('orders.updatePaymentStatus');
            Route::put('/update{id}', [OrderController::class, 'update'])
                ->name('orders.update');
            Route::get('/fetch-quantity', [OrderController::class, 'fetchQuantity'])
                ->name('orders.fetch-quantity');
            Route::get('/edit{id}', [OrderController::class, 'edit'])
                ->name('orders.edit');
            Route::post('/store', [OrderController::class, 'store'])
                ->name('orders.store');
            Route::get('/create', [OrderController::class, 'create'])
                ->name('orders.create');
            Route::get('/', [OrderController::class, 'index'])
                ->name('orders');
        });

        Route::prefix('reviews')->group(function () {
            Route::get('/search', [ReviewController::class, 'search'])
                ->name('reviews.search');// route name luôn phải ở dạng reviews.abcxyz để search box hướng url về phần trước dầu. tức reviews và chấm thêm search
            Route::put('/restore', [ReviewController::class, 'restore'])
                ->name('reviews.restore');
            Route::get('/delete{id}', [ReviewController::class, 'delete'])
                ->name('reviews.delete');
            Route::post('/submitReviewResponse', [ReviewController::class, 'submitReviewResponse'])
                ->name('reviews.submitReviewResponse');
            Route::get('/getSubmitReviewResponse', [ReviewController::class, 'getSubmitReviewResponse'])
                ->name('reviews.getSubmitReviewResponse');
            Route::put('/updateReviewStatus', [ReviewController::class, 'updateReviewStatus'])
                ->name('reviews.updateReviewStatus');
            Route::get('/', [ReviewController::class, 'index'])
                ->name('reviews');
        });
    });

    Route::get("product/search", [HomeProductController::class, 'search'])
        ->name('search');
    Route::get("/", [HomeController::class, 'index'])
        ->name('home');

    Route::post("addToCart", [CartController::class, 'addToCart'])
        ->name('addToCart');
    Route::post("removeFromCart", [CartController::class, 'removeFromCart'])
        ->name('removeFromCart');
    Route::get("cart", [HomeProductController::class, 'cartDisplay'])
        ->name('cartDisplay');
    Route::post("updateCartItem", [CartController::class, 'updateCartItem'])
        ->name('updateCartItem');
    Route::post("submitReview", [HomeProductController::class, 'submitReview'])
        ->name('submitReview');
    Route::get("checkout", [HomeProductController::class, 'checkout'])
        ->name('checkout');
    Route::post("checkCoupon", [HomeProductController::class, 'checkCoupon'])
        ->name('checkCoupon');
    Route::get("get.districts", [HomeProductController::class, 'getDistricts'])
        ->name('get.districts');
    Route::get("validateCheckoutField", [HomeProductController::class, 'validateCheckoutField'])
        ->name('validateCheckoutField');
    Route::post("processCheckout", [HomeProductController::class, 'processCheckout'])
        ->name('processCheckout');
    Route::get("displayreviewsuccess/{order}", [HomeProductController::class, 'displayOrderSuccess'])
        ->name('displayOrderSuccess');
    Route::get("reviewsWithPagination", [HomeProductController::class, 'reviewsWithPagination'])
        ->name('reviewsWithPagination');

    Route::get('/{parentCategorySlug}', [HomeProductController::class, 'listByParentCategory'])
        ->name('homeProducts.listByParentCategory')
        ->where('parentCategorySlug', '[A-Za-z0-9\-]+');
    Route::get('/{parentCategorySlug}/{childCategorySlug}', [HomeProductController::class, 'listByChildCategory'])
        ->name('homeProducts.listByChildCategory')
        ->where(['parentCategorySlug' => '[A-Za-z0-9\-]+', 'childCategorySlug' => '[A-Za-z0-9\-]+']);
    Route::get('/{parentCategorySlug}/{childCategorySlug}/{productSlug}', [HomeProductController::class, 'displayProductDetail'])
        ->name('homeProducts.displayProductDetail')
        ->where([
            'parentCategorySlug' => '[A-Za-z0-9\-]+',
            'childCategorySlug' => '[A-Za-z0-9\-]+',
            'productSlug' => '[A-Za-z0-9\-]+',
        ]);

