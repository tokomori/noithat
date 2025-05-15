<?php

namespace App\Http\Controllers\FrontEnd;

use DB;
use Illuminate\Support\Str;
use App\Slider;
use App\Category;
use App\Products;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Brian2694\Toastr\Facades\Toastr;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            $data = request()->all();

            $query = $data['query'];

            $filter_data = Products::select('product_name')->where('product_name', 'LIKE', '%'.$query.'%')
                            ->get();

            $data = array();
            foreach ($filter_data as $fil)
                {
                    $data[] = $fil->product_name;
                }

            return response()->json($data);
        }
        $hotdeal = Products::where('product_status',1)
                            ->where('product_price_sale','!=', 0)
                            ->inRandomOrder()
                            ->take(1)
                            ->get();
        $startWeek = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth();
        $endWeek = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth();

        $slider = Slider::where('slider_status',1)->orderBy('slider_sorting','asc')->get();
        $new_category = Category::whereNull('category_sub')->where('category_status',1)->take(4)->inRandomOrder()->get();
        $all_product = Products::whereBetween('created_at', [$startWeek,$endWeek])
                                ->where('product_status',1)
                                ->take(4)->inRandomOrder()
                                ->get();
        $best_product = Products::where('product_status',1)->where('product_sold','!=',0)->inRandomOrder()->get();
        $featured_product = Products::where('product_status',1)->orderBy('product_view','desc')->inRandomOrder()->get();

        return view('FrontEnd.forgetpass', compact('hotdeal','slider','new_category','all_product','best_product','featured_product'));
    }
    public function reset_pass(Request $request){
        if(request()->ajax()){
            $data = request()->all();

            $query = $data['query'];

            $filter_data = Products::select('product_name')->where('product_name', 'LIKE', '%'.$query.'%')
                            ->get();

            $data = array();
            foreach ($filter_data as $fil)
                {
                    $data[] = $fil->product_name;
                }

            return response()->json($data);
        }
        $hotdeal = Products::where('product_status',1)
                            ->where('product_price_sale','!=', 0)
                            ->inRandomOrder()
                            ->take(1)
                            ->get();
        $startWeek = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth();
        $endWeek = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth();

        $slider = Slider::where('slider_status',1)->orderBy('slider_sorting','asc')->get();
        $new_category = Category::whereNull('category_sub')->where('category_status',1)->take(4)->inRandomOrder()->get();
        $all_product = Products::whereBetween('created_at', [$startWeek,$endWeek])
                                ->where('product_status',1)
                                ->take(4)->inRandomOrder()
                                ->get();
        $best_product = Products::where('product_status',1)->where('product_sold','!=',0)->inRandomOrder()->get();
        $featured_product = Products::where('product_status',1)->orderBy('product_view','desc')->inRandomOrder()->get();

        return view('FrontEnd.reset_pass', compact('hotdeal','slider','new_category','all_product','best_product','featured_product'));
    }
    public function updatepass(Request $request)
        {
            $data = $request->all();
            $token_random = Str::random();

            $user = User::where('email', $data['email'])
                        ->where('remember_token', $data['remember_token'])
                        ->first();

            if ($user) {
                $user->password = Hash::make($data['password']);
                $user->remember_token = $token_random;
                $user->save();

                Toastr::success('Đã cập nhật mật khẩu thành công, vui lòng đăng nhập lại', 'Hệ Thống');
                return redirect()->back();
            } else {
                Toastr::error('Vui lòng nhập lại email vì link quá hạn', 'Hệ Thống');
                return redirect()->back();
            }
        }
    public function recoverpass(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu Xưởng Mộc Thăng Long".' '.$now;
        $email = $request->input('email');
        $to_email = $email;
        $user = User::where('email', $email)->get();
        foreach($user as $key => $value) {
            $user_id = $value->id;
        }
        if($user){
            $count_customer = $user->count();
            if($count_customer == 0){
                Toastr::error('Email chưa được đăng ký!','Hệ Thống');
                return redirect()->back();
            }
            else
                {
                    $token_random = Str::random();
                    $user = User::find($user_id);
                    $user->remember_token = $token_random;
                    $user->save();
                    //gửi mail

                    $to_mail = $data['email'];//gửi vào email
                    $link_reset_pass = url('/reset_pass?email='.$to_email.'&remember_token='.$token_random);

                    $data = array("name"=>$title_mail,"body"=>$link_reset_pass,'email'=>$data['email']);

                    Mail::send('FrontEnd.forgetpassnoti', ['data'=>$data], function($message) use ($title_mail,$data)
                    {
                        $message->to($data['email'])->subject($title_mail);
                        $message->from($data['email'], $title_mail);
                    });
                    Toastr::success('Đã gửi mail lấy lại mật khẩu, vui lòng kiểm tra mail','Hệ Thống');
                    return redirect()->back();
                }
    
        }
    }
    
    
}
