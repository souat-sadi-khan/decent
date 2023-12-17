<?php

namespace App\Http\Controllers\Frontend;

use App\EcommerceOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Client;
use App\models\eCommerce\PrivacyPolicy;
use App\models\eCommerce\AboutUs;
use App\models\eCommerce\Seo;
use App\models\eCommerce\Slider;
use App\models\eCommerce\TeramsCondition;
use App\models\Production\Category;
use App\models\Production\Product;
use App\models\eCommerce\OurTeam;
use App\models\eCommerce\OurWorkspace;
use App\models\eCommerce\ContactUs;
use App\models\eCommerce\EcommerceProduct;
use App\models\eCommerce\HomePage;
use App\models\eCommerce\PageBanner;
use App\models\eCommerce\ProductRating;
use App\models\eCommerce\SpecialOffer;
use App\models\eCommerce\SpecialOfferItem;
use App\models\eCommerce\Subscriber;
use App\models\eCommerce\Wishlist;
use App\models\Production\Variation;
use App\models\Production\Transaction;
use App\models\inventory\TransactionSellLine;
use App\models\Production\VariationBrandDetails;
use App\WholeSale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Front_End_Controller extends Controller{

    public function view_special_offer_product(Request $request) {
        $id = $request->id;
        
        // find the offer price
        $price_without_dis = 0;
        $price_with_dis = 0;
        $offer_price = SpecialOfferItem::where('product_id', $id)->first();
        $price_without_dis = $offer_price->price_without_dis;
        $price_with_dis = $offer_price->price_with_dis;
        // find the product
        $model = Product::with('photo_details', 'variation')->where('id',$id)->firstOrFail();
        // find the product Rating
        $product_rating = ProductRating::where('product_id',$model->id)->where('status', 1)->get();
        $avarage = $product_rating->sum('rating');
        $total_row = $product_rating->count();
        if ($total_row>0) {
            $avarage_rating = ($avarage / $total_row);
        }else{
            $avarage_rating = 0;
        }
        return view('eCommerce.offer_product_details', compact('model','product_rating','avarage_rating','total_row', 'price_without_dis', 'price_with_dis'));
    }

    public function index(){

        $product_id = [];
        $brand_id = get_option('default_brand');
        $product = EcommerceProduct::all();

        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }


        $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->get();
        
        $best_sellars = Product::whereIn('id', $product_id)->orderByRaw('RAND()')->get();


        $general_products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->take(3)->get();

        $seo  = Seo::first();
        $slider = Slider::all();

        $banner_image_one = HomePage::where('banner_image_one_check',1)->orderBy('id','desc')->first();
        $banner_image_two = HomePage::where('banner_image_two_check',1)->orderBy('id','desc')->first();
        $banner_fream     = HomePage::orderBy('id','desc')->take(3)->get();
        $banner_fream_two = HomePage::orderBy('id','desc')->take(2)->get();
        $featur_product   = Product::where('feature_product_status','1')->orderBy('id','desc')->take(20)->get();

        $footer_featur_product   = Product::where('feature_product_status','1')->orderBy('id','desc')->take(3)->get();
        $hot_sale   = Product::where('hot_sale_status','1')->orderBy('id','desc')->take(3)->get();
        $latest_product   = Product::orderBy('id','desc')->take(3)->get();
        $top_rated = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->take(3)->get();
        return view('eCommerce.index',compact('top_rated','general_products', 'seo','slider','banner_image_one','banner_image_two','banner_fream', 'products','banner_fream_two','featur_product','latest_product','hot_sale','footer_featur_product', 'best_sellars'));

    }

    public function privacyPolicy(){
        $model = PrivacyPolicy::first();
        $banner = PageBanner::where('page_name','Contact')->first();
        return view('eCommerce.privacy_policy',compact('model', 'banner'));
    }

    public function category_product($id){
        // find the category
        $category = Category::with('product')->get();

        $get_categoyr = Category::where('category_slug', $id)->firstOrFail();
        $banner = PageBanner::where('page_name', 'Category')->first();
        $brand_id = get_option('default_brand');
        $product = EcommerceProduct::all();

        $product_id = [];

        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }

        $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->where('category_id', $get_categoyr->id)->paginate(15);
        return view('eCommerce.product_grid_view', compact('category', 'products','banner'));
    }

    public function account()
    {
        $banner = PageBanner::where('page_name', 'Login')->first();
        if (Auth::guard('client')->check()) {
            return Redirect::to('member/dashboard');
        } else {
            return view('eCommerce.account', compact('banner'));
        }
    }


    // special_offer
    public function special_offer($slug) {
        $offer = SpecialOffer::where('offer_slug', $slug)->firstOrFail();
        $items = SpecialOfferItem::where('special_offer_id', $offer->id)->get();
        $banner = PageBanner::where('page_name', 'Category')->first();

        // find the category
        $category = Category::with('product')->get();

        return view('eCommerce.special_offer', compact('offer', 'category', 'items','banner'));

    }

    public function aboutUs(){
        $model = AboutUs::first();
        $our_team = OurTeam::all();
        $our_workspace = OurWorkspace::all();
        return view('eCommerce.about',compact('model','our_team','our_workspace'));
    }

    public function termsCondition(){
        $model = TeramsCondition::first();
        $banner = PageBanner::where('page_name','Contact')->first();
        return view('eCommerce.terms_conditions',compact('model', 'banner'));
    }

    public function contactUs(){
        $banner = PageBanner::where('page_name','Contact')->first();
        return view('eCommerce.contact', compact('banner'));
    }

    public function contact(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'descsription' => 'required',
        ]);
        $data['msg_status'] = 1;
        $model = new ContactUs;
        $model->create($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Message Seed Successfuly'), 'goto' => route('contact')]);
    }

    public function product(){
        $banner = PageBanner::where('page_name', 'Product')->first();
        $product_id = [];
        $brand_id = get_option('default_brand');
        $product = EcommerceProduct::all();
        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }
        $products = Product::whereIn('id', $product_id)->paginate(15);
        $category = Category::with('product')->get();
        return view('eCommerce.product_grid_view', compact('category', 'products','banner'));
    }

    public function product_details($id){
        // find the product
        $model = Product::with('photo_details', 'variation')->where('product_slug',$id)->firstOrFail();
        // find the product Rating
        $product_rating = ProductRating::where('product_id',$model->id)->where('status', 1)->get();
        $avarage = $product_rating->sum('rating');
        $total_row = $product_rating->count();
        if ($total_row>0) {
            $avarage_rating = ($avarage / $total_row);
        }else{
            $avarage_rating = 0;
        }
        return view('eCommerce.product_details', compact('model','product_rating','avarage_rating','total_row'));
    }

    public function offer_details($uuid){
        // offer
        $model = EcommerceOffer::where('slug',$uuid)->firstOrFail();
        // product
        $product = Product::with('photo_details', 'variation')->where('id',$model->product_id)->first();
        $product_rating = ProductRating::where('product_id',$model->id)->where('status', 1)->get();
        $avarage = $product_rating->sum('rating');
        $total_row = $product_rating->count();
        if ($total_row>0) {
            $avarage_rating = ($avarage / $total_row);
        }else{
            $avarage_rating = 0;
        }
        // dd($product);
        return view('eCommerce.offer_details', compact('model', 'product','product_rating','avarage_rating','total_row'));
    }


    public function get_price(Request $request){
        // $price = Variation::findOrFail($request->id);
        $qty = EcommerceProduct::where('variation_id', $request->id)->first();
        $price = EcommerceProduct::where('variation_id', $request->id)->first();
        $qty = $qty->quantity;
        return response()->json(['price' => $price, 'qty' => $qty]);
    }

    public function productRating(Request $request){
        $request->validate([
           'product_id' => 'required',
           'user_id' => '',
           'score' => 'required',
           'name' => 'required',
           'email' => 'required',
           'comment' => 'required',
       ]);
       
       // find the product
       $product = Product::findOrFail($request->product_id);
       $model = new ProductRating;
       $model->product_id=$request->product_id;
       $model->rating=$request->score;
       $model->name=$request->name;
       $model->email=$request->email;
       $model->comment=$request->comment;
       $model->save();
       if ($request->product_id) {
           $retting_model = ProductRating::findOrFail($model->id);
           $product_model = Product::findOrFail($request->product_id);
           $avarage = $retting_model->avg('rating');
           $product_model->avarage_retting = $avarage;
           $product_model->save();
       }
       return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thamks for product rating'), 'goto' => route('product-details', $product->product_slug)]);
   }
   
    // add_into_wishlist
    public function add_into_wishlist(Request $request) {
        $find = Wishlist::where('ip', $request->ip)->where('product_id', $request->id)->first();
        if($find) {
            return response()->json(['success' => true, 'status' => 'warning', 'message' => _lang('Product Already added into your wishlist')]);
        } else {
            $model = new Wishlist;
            $model->ip = $request->ip;
            $model->product_id = $request->id;
            $model->save();
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Product added into your wishlist')]);
        }
    }

    // wishlist
    public function wishlist() {
        $banner = PageBanner::where('page_name', 'Wishlist')->first();
        $ip = getIp();
        $product_id = [];

        $wishlists = Wishlist::where('ip', $ip)->get();
        foreach($wishlists as $wishlist) {
            $product_id[] = $wishlist->product_id;
        }

        $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->get();

        return view('eCommerce.wishlist', compact('products','banner'));
    }

    // delete_into_wishlist
    public function delete_into_wishlist(Request $request) {
        $find = Wishlist::where('ip', $request->ip)->where('product_id', $request->id)->first();
        if($find) {
            $find->delete();
        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Product Removed from your wishlist') , 'load' => true]);
    }

    public function invoice($id) {
        $transaction =  Transaction::where('reference_no',$id)->first();
        $transaction_sale = TransactionSellLine::where('transaction_id',$transaction->id)->get();

        // find the client
        $client = Client::findOrFail($transaction->client_id);
        return view('eCommerce.invoice',compact('transaction','transaction_sale', 'client'));
    }

    // category_offer
    public function category_offer($slug) {
        $category = Category::where('category_slug', $slug)->firstOrFail();

        $product_id = [];
        $brand_id = get_option('default_brand');

        $product = EcommerceProduct::all();

        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }

        $products = Product::whereIn('id', $product_id)->where('category_id', $category->id)->paginate(15);
        $banner = PageBanner::where('page_name', 'Category')->first();

        // All Categoyr
        $category = Category::where('status', 1)->get();
        return view('eCommerce.product_grid_view', compact('category', 'products','banner'));
    }

    // search_product
    public function search_product(Request $request) {
        $text = $request->text;
        $product_id = [];
        $brand_id = get_option('default_brand');


        $product = EcommerceProduct::all();

        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }

        $products = Product::whereIn('id', $product_id)->where('name', 'like', '%' .$text . '%')->paginate(15);
        $banner = PageBanner::where('page_name', 'Category')->first();
        // All Categoyr
        $category = Category::where('status', 1)->get();

        return view('eCommerce.search.search_result_ajax', compact('products', 'banner', 'category'));
    }

    // whole_sale
    public function whole_sale() {
        $model = WholeSale::first();
        $banner = PageBanner::where('page_name','Whole Sale')->first();
        return view('eCommerce.wholesale',compact('model', 'banner'));
    }

    // submit_news_letter_email
    public function submit_news_letter_email(Request $request) {
        $email = $request->news_letter_email;
        if(trim($email) == '') {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Please Enter Your Email Address')]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Please Enter Your Valid Email Address')]);
            
        }

        $check = Subscriber::where('news_letter_email', $email)->first();
        if($check) {
            return response()->json(['success' => true, 'status' => 'warning', 'message' => _lang('You Are Already Subscribed. Thank You !')]);
        }

        $model = new Subscriber;
        $model->news_letter_email = $request->news_letter_email;
        $model->status = 1;
        $model->save();

        return response()->json(['status' => 'success', 'message' => _lang('Thank You For Subcribe')]);

    }
}