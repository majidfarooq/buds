<?php

namespace App\Http\Controllers\backend;

use App\Http\Libraries\StripeHelper;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryDay;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Illuminate\Support\Facades\DB;

class UserPackagePaymentController extends Controller
{


    protected $StripeHelper;

    public function __construct()
    {
        $this->StripeHelper = new StripeHelper();
    }

    public function index($user_slug = null)
    {
        if ($user_slug == null) {
            $user = null;
        } else {
            $user = User::where('slug', $user_slug)->with('payments')->first();
            $paymentids = $user->payments->pluck('id');
        }
        if ($user) {
            $user_package_payments = UserPackagePayment::with('user_package.user', 'user_package.package')->whereIn('id', $paymentids)->orderby('created_at', 'desc')->get();
        } else {
            $user_package_payments = UserPackagePayment::with('user_package.user', 'user_package.package')->orderby('created_at', 'desc')->orderBy('user_package_id', 'desc')->get();
        }

        return view('backend.transactions.index', compact('user_package_payments'));
    }
    public function review()
    {
        $query_array = [];
        $user_package_payments = UserPackagePayment::select('user_package_id', 'payment_date', DB::raw('COUNT(*) as count'))->groupBy('user_package_id', 'payment_date')->orderby('count', 'desc')->get();
        $cnt = 0;
        foreach ($user_package_payments as $upp) {
            $this_upp = UserPackagePayment::where('user_package_id', $upp->user_package_id)->where('payment_date', $upp->payment_date)->get();
            foreach ($this_upp as $tup) {
                if ($tup->status == "refunded" && $tup->deliveriesCount->count() > 0) {
                    $query = "SELECT * FROM `user_package_payments` WHERE user_package_id= '" . $upp->user_package_id . "' AND payment_date='" . $upp->payment_date . "';     SELECT * FROM `deliveries` WHERE `user_package_payment_id` = " . $tup->id;
                    $query_array[$cnt] =   $query;
                    // if ($cnt == 2) {
                    //     $query = "SELECT * FROM `user_package_payments` WHERE user_package_id= '" . $upp->user_package_id . "' AND payment_date='" . $upp->payment_date . "';     SELECT * FROM `deliveries` WHERE `user_package_payment_id` = " . $tup->id;

                    //     // dd($query);
                    // }
                    $cnt++;
                }
            }
        }

        dd($query_array);

        // dd($user_package_payments);
        // $cnt = 0;
        // $str = '';
        // $del_ids = '';
        // foreach ($user_package_payments as $upp) {
        //     if ($upp->count == 5) {
        //         $this_upp = UserPackagePayment::where('user_package_id', $upp->user_package_id)->where('payment_date', $upp->payment_date)->get();
        //         $r_count = 0;
        //         $o_count = 0;
        //         foreach ($this_upp as $t_upp) {
        //             if ($t_upp->status != "refunded") {
        //                 $r_count++;
        //                 $paid_upp_o = $t_upp;
        //             }
        //             if ($t_upp->deliveriesCount->count() > 0) {
        //                 $o_count++;
        //                 $transection_id = $t_upp->transection_id;
        //                 $t_upp->transection_id = 'del_' . $t_upp->transection_id;
        //                 $t_upp->save();
        //             }
        //         }
        //         if ($r_count == 1 && $r_count == 1) {
        //             $n_upp = UserPackagePayment::where('user_package_id', $upp->user_package_id)->where('payment_date', $upp->payment_date)->where('id', '!=', $paid_upp_o->id)->get()->pluck('id');
        //             $paid_upp = UserPackagePayment::where('user_package_id', $upp->user_package_id)->where('payment_date', $upp->payment_date)->where('id', $paid_upp_o->id)->first();
        //             $str .= 'old_tid: ' . $paid_upp->transection_id . '_' . 'new_tid: ' . $transection_id . 'tr_id: ' . $paid_upp->transection_id . '<br>';
        //             foreach ($n_upp as $item) {
        //                 // dd($item);
        //                 $del_ids .= $item . ',';
        //             }
        //             $paid_upp->transection_id = $transection_id;
        //             $paid_upp->save();
        //         }
        //     }
        //     $cnt++;
        // }
        // UserPackagePayment::whereIn('id', [
        //     177, 178, 179, 181, 180, 182, 183, 184, 187, 188, 189, 190, 192, 193, 194, 195, 196, 198, 199, 200, 202, 203, 204, 205, 207, 208, 209, 210, 211, 213, 214, 215, 221, 223, 224, 225, 227, 228, 229, 230, 233, 234, 236, 237, 238, 240, 242, 243, 247, 248, 249, 250, 253, 254, 255, 256, 257, 259, 260, 261, 267, 269, 270, 271, 273, 274, 275, 276, 278, 279, 280, 281, 282, 284, 285, 286, 287, 288, 289, 291, 294, 295, 296, 297
        // ])->delete();
        // $t_u_p = UserPackagePayment::whereIn('id', [
        //     177, 178, 179, 181, 180, 182, 183, 184, 187, 188, 189, 190, 192, 193, 194, 195, 196, 198, 199, 200, 202, 203, 204, 205, 207, 208, 209, 210, 211, 213, 214, 215, 221, 223, 224, 225, 227, 228, 229, 230, 233, 234, 236, 237, 238, 240, 242, 243, 247, 248, 249, 250, 253, 254, 255, 256, 257, 259, 260, 261, 267, 269, 270, 271, 273, 274, 275, 276, 278, 279, 280, 281, 282, 284, 285, 286, 287, 288, 289, 291, 294, 295, 296, 297
        // ])->get();
        // old_tid: ch_3MbuSdF6NIretIdz1d1eQb9u_new_tid: ch_3MbuSfF6NIretIdz1COOPi3str_id: <br>old_tid: ch_3MbuShF6NIretIdz0zQSdcRw_new_tid: ch_3MbuShF6NIretIdz0zQSdcRwtr_id: <br>old_tid: ch_3MbuSjF6NIretIdz0pBCBQHG_new_tid: ch_3MbuSlF6NIretIdz0fhhKedBtr_id: <br>old_tid: ch_3MbuSlF6NIretIdz0KpsUjKf_new_tid: ch_3MbuSnF6NIretIdz1k3kYjjYtr_id: <br>old_tid: ch_3MbuSoF6NIretIdz10BqshjC_new_tid: ch_3MbuSqF6NIretIdz0E08s0kQtr_id: <br>old_tid: ch_3MbuSqF6NIretIdz1MeFQcF3_new_tid: ch_3MbuSrF6NIretIdz1dAD33ZItr_id: <br>old_tid: ch_3MbuSrF6NIretIdz1Wg8zbGY_new_tid: ch_3MbuStF6NIretIdz1QIFS3EEtr_id: <br>old_tid: ch_3MbuStF6NIretIdz1sj65a4K_new_tid: ch_3MbuSvF6NIretIdz1Qa36TsGtr_id: <br>old_tid: ch_3MbuSxF6NIretIdz1lPvR1W8_new_tid: ch_3MbuSyF6NIretIdz1VqOmwtOtr_id: <br>old_tid: ch_3MbuSzF6NIretIdz16tjIyis_new_tid: ch_3MbuT0F6NIretIdz0SqrfhjJtr_id: <br>old_tid: ch_3MbuT3F6NIretIdz0Bos4UnH_new_tid: ch_3MbuT4F6NIretIdz1Hf0GzlLtr_id: <br>old_tid: ch_3MbuT5F6NIretIdz0xUwTzwj_new_tid: ch_3MbuT6F6NIretIdz0wCAXwSTtr_id: <br>old_tid: ch_3MbuT7F6NIretIdz01kGYvvw_new_tid: ch_3MbuT8F6NIretIdz0VQaW7MBtr_id: <br>old_tid: ch_3MbuT9F6NIretIdz1WLxNE06_new_tid: ch_3MbuTBF6NIretIdz0VMS4c1etr_id: <br>old_tid: ch_3MbuTBF6NIretIdz0cPu861g_new_tid: ch_3MbuTCF6NIretIdz0ngev242tr_id: <br>old_tid: ch_3MbuTFF6NIretIdz0lYXuVxq_new_tid: ch_3MbuTGF6NIretIdz0pwEAI9Ltr_id: <br>old_tid: ch_3MbuTGF6NIretIdz0jFuSVqj_new_tid: ch_3MbuTHF6NIretIdz0uimnSqotr_id: <br>old_tid: ch_3MbuTJF6NIretIdz1HNhpTpK_new_tid: ch_3MbuTJF6NIretIdz1Zxilq6Etr_id: <br>old_tid: ch_3MbuTKF6NIretIdz1lG0OH0u_new_tid: ch_3MbuTLF6NIretIdz1jk2sh1vtr_id: <br>old_tid: ch_3MbuTMF6NIretIdz0C4u8aKS_new_tid: ch_3MbuTMF6NIretIdz12zDwsQHtr_id: <br>old_tid: ch_3MbuTQF6NIretIdz0ZUgNU4P_new_tid: ch_3MbuTQF6NIretIdz0qoxHdDttr_id: <br>
        // foreach ($t_u_p as $tup) {
        //     if ($tup->deliveriesCount->count() > 0) {
        //         // dd($tup->id);
        //     }
        // }
        // dd($str, $del_ids);
    }

    public function show($id)
    {
        $user_package_payment = UserPackagePayment::whereid($id)->with('user_package.user', 'user_package.package', 'deliveries.delivery_day')->orderby('created_at', 'desc')->first();
        return view('backend.transactions.show', compact('user_package_payment'));
    }

    public function edit()
    {
        return view('backend.transactions.create');
    }

    public function refund($id)
    {

        $status = $this->StripeHelper->refundCharge($id);
        if ($status->id) {
            return redirect()->back()->with('success', 'Refunded Successfully.');
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
}
