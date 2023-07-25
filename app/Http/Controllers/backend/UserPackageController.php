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


class UserPackageController extends Controller
{


    protected $StripeHelper;
    public function __construct()
    {
        $this->StripeHelper = new StripeHelper();
    }

    public function index(Request $request)
    {
        $user_packages = UserPackage::with('user', 'package')->get();
        return view('backend.user_package.index', compact('user_packages'));
    }
    public function show($id)
    {
        $user_package = UserPackage::whereId($id)->with('user', 'package')->first();
        return view('backend.user_package.show', compact('user_package'));
    }
    public function suspend_delivery(Request $request)
    {
        $user_package = UserPackage::whereId($request->user_package_id)->first();
        $user_package->suspended_until = $request->suspended_until;
        if ($user_package->status == 'active') {
            $user_package->status = 'suspended';
        } else {
            $user_package->status = 'active';
        }
        if ($user_package->save()) {
            return redirect()->back()->with(['success' => 'Delivery Suspend Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
    public function activate_delivery($id)
    {
        $activate_package = UserPackage::whereId($id)->first();
        $activate_package->suspended_until = NULL;
        if ($activate_package->status == 'suspended') {
            $activate_package->status = 'active';
        } else {
            $activate_package->status = 'suspended';
        }
        if ($activate_package->save()) {
            return redirect()->back()->with(['success' => 'Delivery Activate..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
    public function cancelThisWeek(Request $request)
    {
        $delivery_day = DeliveryDay::whereId($request->delivery_day_id)->with('deliveries')->first();
        $delivery_day->status = 'Canceled';
        foreach ($delivery_day->deliveries as $delivery) {
            if ($delivery->status == 'Pending') {
                $delivery->status = 'Canceled';
                $delivery->save();
            }
        }
        $delivery_day->save();
        return back()->with(['status' => $delivery_day]);
    }

    public function runBulkTrasections(Request $request)
    {

        $delivery_day = DeliveryDay::whereId($request->delivery_day_id)->with('deliveries.user_package.user')->first();
        $error_logs = [];
        foreach ($delivery_day->deliveries as $delivery) {
            if ($delivery->status == 'Pending') {
                if ($delivery->user_package->remaining_deliveries > 0) {
                    $userPackagePayment = UserPackagePayment::where('user_package_id', $delivery->user_package->id)->orderby('payment_date', 'ASC')->get();
                    $remaining_quantity = $userPackagePayment->where('remaining_quantity', '>', 0)->first();
                    if (!empty($remaining_quantity)) {
                        $delivery->user_package_payment_id = $remaining_quantity->id;
                        $delivery->status = 'Paid';
                    } else {
                        $delivery->status = 'Failed';
                        $error_logs[$delivery->id] = "There is some calculation mistake as Subscription's remaining_deliveries are " . $delivery->user_package->remaining_deliveries . " but there is no Paments which have less deliveries";
                    }
                } elseif (isset($delivery->user_package->user->stripe_id) && !empty($delivery->user_package->user->stripe_id)) {
                    $amount = $delivery->user_package->package->amount;
                    $customerStripe = $this->StripeHelper->getCustomer($delivery->user_package->user->stripe_id);
                    if (isset($customerStripe->invoice_settings->default_payment_method) && !empty($customerStripe->invoice_settings->default_payment_method)) {
                        $charge = $this->StripeHelper->createCharge($amount, $delivery->user_package->user->stripe_id, $customerStripe->invoice_settings->default_payment_method);
                        if (!$charge) {
                            $error_logs[$delivery->id] = 'Transection was not successsful';
                            $delivery->status = 'Failed';
                        } else {
                            $userPackagePayment = new UserPackagePayment();
                            $userPackagePayment->user_package_id = $delivery->user_package->id;
                            $userPackagePayment->type = 'cc';
                            $userPackagePayment->quantity = 1;
                            $userPackagePayment->amount = $delivery->user_package->package->amount;
                            $userPackagePayment->payment_date = today();
                            $userPackagePayment->transection_id = $charge->id;
                            $userPackagePayment->save();
                            $delivery->user_package_payment_id = $userPackagePayment->id;
                            $delivery->status = 'Paid';
                        }
                    } else {
                        $error_logs[$delivery->id] = 'No Card Attached';
                        $delivery->status = 'Failed';
                    }
                } else {
                    $error_logs[$delivery->id] = "There is some calculation mistake as Subscription's remaining_deliveries are " . $delivery->user_package->remaining_deliveries . " but there is no Paments which have less deliveries";
                    $delivery->status = 'Failed';
                }
                $delivery->save();
            }
        }
        $delivery_day->status = 'Completed';
        if (!empty($error_logs)) {
            $delivery_day->error_logs = json_encode($error_logs);
        } else {
        }
        $delivery_day->save();

        return back()->with(['status' => $delivery_day]);
    }

    public function destroy($id)
    {
        $UserPackage = UserPackage::whereId($id)->first();
        if ($UserPackage->delete()) {
            return redirect()->back()->with(['success' => 'Subscription Deleted Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
}
