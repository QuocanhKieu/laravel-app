<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Constants\OrderConstants;
use App\Constants\ReviewStatusConstants;
use App\Constants\VouchersList;
use App\Helpers\ParentCategoriesHelper;
use App\Models\Category;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\PaymentInfo;
use App\Models\Product;
use App\Models\Province;
use App\Models\Review;
use App\Models\Voucher;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\throwException;

class HomeProductController extends Controller
{
    public function listByParentCategory($parentCategorySlug){
        $parentCategories = ParentCategoriesHelper::returnParentCategories();
        try {
        $thisParentCategory = Category::where('slug', $parentCategorySlug)->firstOrFail();
        $productsByParentCategory = $thisParentCategory->allProducts();
        dd($productsByParentCategory->count());
        }catch (ModelNotFoundException $e) {
            // Redirect to a 404 page if any model is not found
            abort(404);
        } catch (\Exception $e) {
            // Redirect to a 404 page for any other exceptions
            abort(404);
        }
    }

    public function listByChildCategory($parentCategorySlug, $childCategorySlug){
        $parentCategories = ParentCategoriesHelper::returnParentCategories();
        try {
            $thisParentCategory = Category::where('slug', $parentCategorySlug)->firstOrFail();

            $thisChildCategory = $thisParentCategory->children->where('slug', $childCategorySlug)->firstOrFail();
//            dd($thisChildCategory->id);
            $productsByChildCategory = $thisChildCategory->products();
            dd($productsByChildCategory->count());
        } catch (ModelNotFoundException $e) {
            // Redirect to a 404 page if any model is not found
            abort(404);
        } catch (\Exception $e) {
            // Redirect to a 404 page for any other exceptions
            abort(404);
        }
    }
    public function displayProductDetail($parentCategorySlug, $childCategorySlug, $productSlug){
        $parentCategories = ParentCategoriesHelper::returnParentCategories();
        try {
            // Fetch parent category
            $parentCategory = Category::where('slug', $parentCategorySlug)->firstOrFail();
            // Fetch child category
            $childCategory = Category::where('slug', $childCategorySlug)->where('parent_id', $parentCategory->id)->firstOrFail();
            // Fetch product
            $product = Product::where('slug', $productSlug)->where('category_id', $childCategory->id)->firstOrFail();

            $breadcrumbs = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => $parentCategory->name, 'url' => route('homeProducts.listByParentCategory', $parentCategory->slug)],
                ['name' => $childCategory->name, 'url' => route('homeProducts.listByChildCategory', ['parentCategorySlug' => $parentCategory->slug, 'childCategorySlug' => $childCategory->slug])],
                ['name' => $product->name, 'url' => ''] // No URL for the current page
            ];

            $watchedProductIds = Session::get('watched_products', []);

            if (!in_array($product->id, $watchedProductIds)) {
                $watchedProductIds[] = $product->id;
                Session::put('watched_products', $watchedProductIds);
            }


            $watchedProductIdsExcludeThis = array_diff($watchedProductIds, [$product->id]);
            $watchedProductsExcludeThis = Product::whereIn('id', $watchedProductIdsExcludeThis)->get();

            // Fetch related products
            $relatedProducts = Product::where('category_id', $childCategory->id)
                ->where('id', '!=', $product->id)
                ->take(8) // Limit the number of related products
                ->get();

//            dd($relatedProducts);
            return view('productDetail', [
                'parentCategories' => $parentCategories,
                'breadcrumbs' => $breadcrumbs,
                'product' => $product,
                'watchedProductsExcludeThis' => $watchedProductsExcludeThis,
                'relatedProducts' => $relatedProducts
            ]);
        }catch (ModelNotFoundException $e) {
            // Redirect to a 404 page if any model is not found
            abort(404);
        } catch (\Exception $e) {
            // Redirect to a 404 page for any other exceptions
            abort(404);
        }
    }

    public function cartDisplay(){
        $parentCategories = ParentCategoriesHelper::returnParentCategories();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Giỏ Hàng', 'url' => ''] // No URL for the current page
        ];

        return view('cartDetail', [
            'parentCategories' => $parentCategories,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function checkout() {
        $provinces = Province::all();
        $parentCategories = ParentCategoriesHelper::returnParentCategories();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Checkout', 'url' => ''] // No URL for the current page
        ];

        return view('checkout', [
            'parentCategories' => $parentCategories,
            'breadcrumbs' => $breadcrumbs,
            'provinces' => $provinces
        ]);
    }
    public function checkCoupon(Request $request)
    {
        $voucherCode = $request->input('voucherCode');
        $totalPrice = $request->input('totalPrice');
        $discount = 0;

        // Query the voucher from the database
        $voucher = Voucher::where('code', $voucherCode)->first();
        if ($voucher && $totalPrice >= $voucher->minPurchase) {
            $discount = $voucher->discountAmount;
        }

        if ($discount > 0) {
            $newTotalPrice = $totalPrice - $discount;
            $view = view('partials.totalBlock', compact('discount', 'newTotalPrice', 'voucherCode'))->render();
            return response()->json(['success' => true, 'view' => $view]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid voucher or minimum purchase not met.']);
        }
    }
    public function getDistricts(Request $request) {
        $districts = District::where('province_code', $request->province_code)->get();
        if (!$districts->isEmpty()) {
            $view = view('partials.districtsOptions', compact('districts'))->render();
            return response()->json(['success' => true, 'view' => $view]);
        } else {
            return response()->json(['success' => false, 'message' => 'Districts is empty.']);
        }
    }
    public function displayOrderSuccess(Request $request, $order_id)
    {
        $parentCategories = ParentCategoriesHelper::returnParentCategories();

            $order = Order::findOrFail($order_id);
        session()->forget('cart');



        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Đặt Hàng Thành Công', 'url' => ''] // No URL for the current page
        ];
        return view('orderSuccess', [
            'parentCategories' => $parentCategories,
            'breadcrumbs' => $breadcrumbs,
            'order' => $order
        ]);
    }
    public function validateCheckoutField(Request $request) {
        // Define validation rules for each input field
        $input = $request->all();

        $rules = [
            'payment_address_name' => 'required|min:1|max:96',
            'payment_address_email' => 'required|email|max:96',
            'payment_address_telephone' => 'required|digits_between:10,11',
            'payment_address_telephone_confirm' => 'required|same:payment_address_telephone|digits_between:10,11',
            'payment_address_province' => 'required|',
            'payment_address_district' => 'required|',
            'payment_address_ward' => 'required|min:3|max:128',
            'payment_address_address_detail' => 'required|min:3|max:255',
            // Add rules for other forms...
        ];

        // Define custom error messages
        $messages = [
            'payment_address_name.required' => 'Họ và Tên không được để trống.',
            'payment_address_name.min' => 'Họ và Tên phải có ít nhất :min ký tự.',
            'payment_address_name.max' => 'Họ và Tên không được vượt quá :max ký tự.',
            'payment_address_email.required' => 'E-Mail không được để trống.',
            'payment_address_email.email' => 'E-Mail không hợp lệ.',
            'payment_address_email.max' => 'E-Mail không được vượt quá :max ký tự.',
            'payment_address_telephone.required' => 'Điện thoại không được để trống.',
            'payment_address_telephone.digits_between' => 'Điện thoại phải có từ :min đến :max chữ số.',
            'payment_address_telephone.same' => 'Xác nhận Điện thoại phải trùng với Điện thoại.',
            'payment_address_telephone_confirm.digits_between' => 'Điện thoại phải có từ :min đến :max chữ số.',
            'payment_address_telephone_confirm.required' => 'Xác nhận Điện thoại không được để trống.',
            'payment_address_telephone_confirm.same' => 'Xác nhận Điện thoại phải trùng với Điện thoại.',
            'payment_address_province.required' => 'Tỉnh Thành không được để trống.',
            'payment_address_district.required' => 'Quận Huyện không được để trống.',
            'payment_address_ward.required' => 'Xã / Phường không được để trống.',
            'payment_address_ward.min' => 'Xã / Phường phải có ít nhất :min ký tự.',
            'payment_address_ward.max' => 'Xã / Phường không được vượt quá :max ký tự.',
            'payment_address_address_detail.required' => 'Địa chỉ không được để trống.',
            'payment_address_address_detail.min' => 'Địa chỉ phải có ít nhất :min ký tự.',
            'payment_address_address_detail.max' => 'Địa chỉ không được vượt quá :max ký tự.',
            // Add messages for other forms...
        ];

        // Validate the request
        $validator = Validator::make($input, $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation errors in JSON format
            return response()->json(['success' => false, 'message' => 'Invalid fields' , 'errors' => $validator->errors()->toArray()]);
        }

        // If validation passes, return success
        return response()->json(['success' => true, 'data' => $request->all()]);
    }
    public function processCheckout(Request $request) {
        $validationResponse = $this->validateCheckoutField($request);
        // Check if validation failed
        if (!$validationResponse->getData()->success) {
            // Return validation errors to the AJAX call
            return $validationResponse;
        }
        $validatedData = $validationResponse->getData()->data;
        // always create order first and add default data first

        $order = $this->createOrder($validatedData);// making order

        if($order) {
            $redirect_url = '';
            switch ($validatedData->payment_method){
                case 'onepay_atm':
                    $redirect_url = route('paymentGatewayATM', ['order' => $order->id]);
                    break;
                case 'onepay_credit':
                    $redirect_url = redirect()->route('paymentGatewayCredit', ['order' => $order->id]);
                    break;
                case 'cod':
                case 'bank_transfer':
                    $redirect_url = route('displayOrderSuccess', ['order' => $order->id]);
                    break;
            }
            // Default response if no specific condition matches
            return response()->json(['success' => true, 'message' => 'Processing order...', 'redirect_url' => $redirect_url]);
        }
       return response()->json(['success' => false, 'message' => 'Tạo order thất bại']);
    }
    private function createOrder($validatedData)
    {
        try {
            DB::beginTransaction();
            $cartData = Session::get('cart');
            if(empty($cartData)) {
                throw new Exception("Giỏ Hàng Trống");
            }
            $voucher = Voucher::where('code', $validatedData->voucher_code)->first();
            $voucher_id = $voucher ? $voucher->id : null;
//            dd($cartData = json_decode(json_encode($cartData)));
//--------------
//            dd($validatedData);
            $order = Order::create([
                'user_id' => Auth::id(),
                'json_order_items' => json_encode($cartData),
                'total_quantity' => $cartData['cartTotalQuantity'],
                'sub_total_amount' => $cartData['cartTotalPrice'],
                'voucher_id' => $voucher_id,
                'total_discount' => $voucher ? $voucher->discountAmount : 0,
                'total_tax' => 0,
                'delivery_fee' =>$validatedData->shipping_method,
                'total_amount' => $validatedData->cartTotalPrice,// final total price customer has to pay yet including delivery_fee
                'payment_method' => $validatedData->payment_method,
                'payment_status' => OrderConstants::PAYMENTSTATUSES[1]['status'],
                'order_status' => OrderConstants::ORDERSSTATUSES[1]['status'],
                'order_note' => $validatedData->order_note,
                // 'created_at' and 'updated_at' are automatically handled by Laravel
            ]);
            if($order) {
                foreach ($cartData['products'] as $key => $product) {
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id, // replace with actual order id
                        'order_code' => $order->order_code, // replace with actual order code
                        'product_id' => $product['product_id'], // replace with actual product id
                        'size_id' => $product['size_id'], // replace with actual size id
                        'product_name' => $product['thisProduct']->name, // replace with actual product name
                        'quantity' => $product['quantity'], // replace with actual quantity
                        'price' => $product['price'], // replace with actual price
                        'total_price' => $product['totalPrice'], // replace with actual total price
                    ]);
                }
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id, // replace with actual order id
                    'order_code' => $order->order_code, // replace with actual order code
                    'name' => $validatedData->payment_address_name, // replace with actual name
                    'phone_number' => $validatedData->payment_address_telephone, // replace with actual phone number
                    'email' => $validatedData->payment_address_email, // replace with actual email
                    'province_code' => $validatedData->payment_address_province, // replace with actual province code
                    'district_code' => $validatedData->payment_address_district, // replace with actual district code
                    'ward' => $validatedData->payment_address_ward, // replace with actual ward
                    'delivery_address_detail' => $validatedData->payment_address_address_detail, // replace with actual delivery address detail
                ]);
            }
            DB::commit();
            return $order;
        }catch (\Exception $exception) {
            // If an exception occurs, rollback the transaction
            DB::rollback();
            $detailedError = 'Message: '.$exception->getMessage() . ' --- File: ' . $exception->getFile() . ' --- Line: ' . $exception->getLine();
            Log::error($detailedError);
            dd($detailedError);
            // Flash the detailed error message to the session
           return false;
        }
    }
    public function validateReviewSubmit(Request $request) {
        // Define validation rules for each input field
        $input = $request->all();

        $rules = [
            'name' => 'required|min:1|max:96',
            'rating' => 'required|digits_between:1,5',
            // Add rules for other forms...
        ];

        // Define custom error messages
        $messages = [
            'name.required' => 'Họ và Tên không được để trống.',
            'name.min' => 'Họ và Tên phải có ít nhất :min ký tự.',
            'name.max' => 'Họ và Tên không được vượt quá :max ký tự.',
            'rating.required' => 'Số sao không được để trống.',
            'rating.digits_between' => 'Số sao từ :min đến :max chữ số.',
            // Add messages for other forms...
        ];
        // Validate the request
        $validator = Validator::make($input, $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation errors in JSON format
            return response()->json(['success' => false, 'message' => 'Invalid fields' , 'errors' => $validator->errors()->toArray()]);
        }

        // If validation passes, return success
        return response()->json(['success' => true, 'data' => $request->all()]);
    }
    public function submitReview(Request $request) {
        $validationResponse = $this->validateReviewSubmit($request);
        // Check if validation failed
        if (!$validationResponse->getData()->success) {
            // Return validation errors to the AJAX call
            return $validationResponse;
        }
        $validatedData = $validationResponse->getData()->data;
        // always create order first and add default data first

//        $review = $this->createOrder($validatedData);// making order
        $review = Review::create([
            'user_id' => Auth::id(), // Replace with the actual user ID
            'name' => $validatedData->name,
            'product_id' => $validatedData->product_id, // Replace with the actual product ID
            'review_text' => $validatedData->review_text,
            'rating' => $validatedData->rating,
            'status' => ReviewStatusConstants::REVIEWSTATUSES[1], // Or any default status value you have
        ]);

        if($review) {
            // Default response if no specific condition matches
            return response()->json(['success' => true, 'message' => 'Đánh giá thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Đánh giá thất bại']);
    }
    public function search(Request $request)
    {
        $tagName = $request->query('tag');
        $searchTerm = $request->query('search');
        $searchKind = $tagName? 'tag':( $searchTerm ? 'search': null);
        switch ($searchKind) {
            case 'tag':
                $products = Product::whereHas('tags', function ($query) use ($tagName) {
                    $query->where('name', $tagName);
                })->get();
                dd($products->count(), $tagName);
                return view('search', compact('products', 'tagName'));
            case 'search';
                $products = Product::where(function ($query) use ($searchTerm) {
                    $query->where('id', 'like', "%$searchTerm%")
                        ->orWhere('name', 'like', "%$searchTerm%")
                        ->orWhere('sale_price', 'like', "%$searchTerm%")
                        ->orWhere('price', 'like', "%$searchTerm%");
                })
                    // Use orWhereHas to search in related models
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', "%$searchTerm%");
                    })
                    ->orWhereHas('brand', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', "%$searchTerm%");
                    })
                    ->orWhereHas('tags', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', "%$searchTerm%");
                    })
                    ->latest()->paginate(5);;
                dd($products->count(), $searchTerm);
                return view('search', compact('products', 'searchTerm'));
            default:
                return redirect()->back()->with('error', 'Tag or Search term is required.');
        }
    }
    public function sort(Request $request)
    {
        $tag = $request->query('tag');
        if (!$tag) {
            return redirect()->back()->with('error', 'Tag parameter is not found.');
        }
        $products = Product::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        })->get();

        return view('search', compact('products', 'tag'));
    }
}
