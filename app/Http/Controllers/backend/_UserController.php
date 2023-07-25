<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Http\Libraries\StripeHelper;
use App\Models\Delivery;
use App\Models\User;
use App\Models\Package;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;

class _UserController extends Controller
{

    protected $StripeHelper;
    public function __construct()
    {
        $this->StripeHelper = new StripeHelper;
    }


    public function index(Request $request)
    {
        $users = User::get();
        return view('backend.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::withTrashed()->whereSlug($id)->with('user_packages.package')->first();
        $paymentMethods = '';
        $customerStripe = '';
        if (isset($user->stripe_id) && !empty($user->stripe_id)) {
            $customerStripe = $this->StripeHelper->getCustomer($user->stripe_id);
            $paymentMethods = $this->StripeHelper->paymentMethods($user->stripe_id);
        }
        return view('backend.users.show', compact('user', 'paymentMethods', 'customerStripe'));
    }

    public function create()
    {
        return view('backend.users.create');
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'billing_coordinates' => 'required',
                'phone' => 'unique:users',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                if (isset($data['same_as_billing_address']) && $data['same_as_billing_address'] == 'on') {
                    $data["delivery_address1"] = $data["billing_address1"];
                    $data["delivery_address2"] = $data["billing_address2"];
                    $data["delivery_city"] = $data["billing_city"];
                    $data["delivery_state"] = $data["billing_state"];
                    $data["delivery_zip"] = $data["billing_zip"];
                    $data["delivery_coordinates"] = $data["billing_coordinates"];
                }
                if (isset($data['same_as_customer']) && $data['same_as_customer'] == 'on') {
                    $data["recipient_name"] = $data["first_name"] . " " . $data["last_name"];
                    $data["recipient_phone"] = $data["phone"];
                }
                $user = new User();
                $fillable = $user->getFillable();
                foreach ($fillable as $columnName) {
                    if (isset($data[$columnName]) && $data[$columnName]) {
                        if ($data[$columnName] != $user[$columnName]) {
                            $user[$columnName] = $data[$columnName];
                        }
                    }
                }
                $user->save();
                return redirect()->route('admin.users.index')->with('success', 'User Created Successfully.');
            }
        } catch (\Exception $e) {

            $error = $e->getMessage();

            return redirect()->back()->with('error', $error);
        }
    }

    public function edit(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->first();
        return view('backend.users.edit', compact('user', 'user'));
    }
    public function update(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->first();
        $fillable = $user->getFillable();
        try {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
            ];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error)->withErrors($validator)->withInput();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                if (isset($data['same_as_billing_address']) && $data['same_as_billing_address'] == 'on') {
                    $data["delivery_address1"] = $data["billing_address1"];
                    $data["delivery_address2"] = $data["billing_address2"];
                    $data["delivery_city"] = $data["billing_city"];
                    $data["delivery_state"] = $data["billing_state"];
                    $data["delivery_zip"] = $data["billing_zip"];
                    $data["delivery_coordinates"] = $data["billing_coordinates"];
                }
                if (isset($data['same_as_customer']) && $data['same_as_customer'] == 'on') {
                    $data["recipient_name"] = $data["first_name"] . " " . $data["last_name"];
                    $data["recipient_phone"] = $data["phone"];
                }
                foreach ($fillable as $columnName) {
                    if (isset($data[$columnName]) && $data[$columnName]) {
                        if ($data[$columnName] != $user[$columnName]) {
                            $user[$columnName] = $data[$columnName];
                        }
                    }
                }
                if ($user->save()) {
                    return redirect()->route('admin.users.show', $user->slug)->with('success', 'User Updated Successfully.');
                }
            }
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong.");
        }
    }
    public function assign_package(Request $request, $id)
    {
        $user = User::where('id', $id)->with('user_packages.package')->first();
        $paymentMethods = '';
        $customerStripe = '';
        $defaultPayment = '';
        if (isset($user->stripe_id) && !empty($user->stripe_id)) {
            $customerStripe = $this->StripeHelper->getCustomer($user->stripe_id);
            if (isset($customerStripe->invoice_settings->default_payment_method)) {
                $defaultPayment = $this->StripeHelper->retrievePaymentMethod($customerStripe->invoice_settings->default_payment_method);
            }
            $paymentMethods = $this->StripeHelper->paymentMethods($user->stripe_id);
        }
        $packages = Package::get();
        return view('backend.users.assign_package', compact('user', 'packages', 'defaultPayment', 'customerStripe', 'paymentMethods'));
    }

    public function addnewCardCustomer(Request $request)
    {
        $data = $request->except(['_method', '_token']);
        if (isset($data['user_id'])) {
            $userClient = User::where('id', $data['user_id'])->first();
            if (empty($userClient->stripe_id)) {
                $user = $this->StripeHelper->createCustomer($userClient->email);
                $this->StripeHelper->createSource($user->id, $data['stripeToken']);
                $userClient->stripe_id = $user->id;
                $userClient->update();
            } else {
                $this->StripeHelper->createSource($userClient->stripe_id, $data['stripeToken']);
            }
        }
        return redirect()->back()->with('success', "Source Added Successfully.");
    }

    public function createUserAsingCard(Request $request)
    {

        $data = $request->except(['_method', '_token']);
        if (isset($data['customer_id'])) {
            if (isset($data['default'])) {
                $this->StripeHelper->updateDefaultMethod($data['customer_id'], $data['payment_method']);
                return redirect()->back()->with('success', "Default Source Changed Successfully.");
            } else {
                $this->StripeHelper->removePaymentMethods($data['payment_method']);
                return redirect()->back()->with('success', "Source Deleted Successfully.");
            }
        } else {
            return redirect()->back()->with('error', "Something went wrong..");
        }
    }

    public function assign_package_submission(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'package_id' => 'required',
                'type' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                $userClient = User::whereid($data['user_id'])->first();

                $userpackage = new UserPackage();
                $fillable = $userpackage->getFillable();
                //  'user_id','package_id','type','day','description',
                foreach ($fillable as $columnName) {
                    if (isset($data[$columnName]) && $data[$columnName]) {
                        $userpackage[$columnName] = $data[$columnName];
                    }
                }
                $userpackage->save();

                if ($data['paid_via'] == 'other') {
                    $user_package_payment = new UserPackagePayment();
                    // 'user_package_id', 'type', 'quantity', 'amount', 'payment_date', 'description', 'transection_id', 'attachment'
                    $data['user_package_id'] = $userpackage->id;
                    $fillable = $user_package_payment->getFillable();

                    foreach ($fillable as $columnName) {
                        if ($columnName == 'type') {
                            if (isset($data['paid_via']) && $data['paid_via']) {
                                $user_package_payment[$columnName] = $data['paid_via'];
                            }
                        } elseif ($columnName == 'description') {
                            if (isset($data['payment_description']) && $data['payment_description']) {
                                $user_package_payment[$columnName] = $data['payment_description'];
                            }
                        } elseif ($columnName == 'attachment') {
                            if (isset($data['attachment']) && $data['attachment']) {
                                $user_package_payment->attachment = (new Helpers())->uploadFile($data['attachment'], 'transections');
                            }
                        } else {
                            if (isset($data[$columnName]) && $data[$columnName]) {
                                $user_package_payment[$columnName] = $data[$columnName];
                            }
                        }
                    }
                    $user_package_payment->save();
                } else {
                }
                return redirect()->route('admin.users.index')->with('success', 'User Created Successfully.');
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect()->back()->with('error', $error);
        }
    }

    public function assign_total_credits(Request $request, $id)
    {
        $UserPackage = UserPackage::where('id', $id)->with('package', 'user')->first();
        $paymentMethods = '';
        $customerStripe = '';
        $defaultPayment = '';
        if (isset($UserPackage->user->stripe_id) && !empty($UserPackage->user->stripe_id)) {
            $stripe = new \Stripe\StripeClient('sk_test_uUYdnWXxbxABci3slybp9rJS');
            $customerStripe = $stripe->customers->retrieve($UserPackage->user->stripe_id);
            if (isset($customerStripe->invoice_settings->default_payment_method)) {
                $defaultPayment = $stripe->paymentMethods->retrieve(
                    $customerStripe->invoice_settings->default_payment_method,
                    []
                );
            }
            $paymentMethods = $stripe->paymentMethods->all([
                'customer' => $UserPackage->user->stripe_id,
                'type' => 'card',
            ]);
        }
        return view('backend.users.assign_total_credit', compact('UserPackage', 'paymentMethods', 'defaultPayment', 'customerStripe'));
    }

    public function assign_package_payments(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'user_package_id' => 'required',
                'amount' => 'required',
                'quantity' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                $amountToCharge = ($request['package_unit_price'] * $request['quantity']);
                $stripe = new \Stripe\StripeClient('sk_test_uUYdnWXxbxABci3slybp9rJS');
                $userClient = User::whereid($data['user_id'])->first();
                if ($data['type'] == 'cc' && empty($userClient->stripe_id)) {
                    dd('if');
                    $user =  $stripe->customers->create([
                        'email' => $userClient->email,
                        'description' => 'Buds',
                    ]);
                    $userClient->stripe_id = $user->id;
                    $userClient->update();
                    $sourceCreate = $stripe->customers->createSource(
                        $userClient->stripe_id,
                        ['source' => $data['stripeToken']]
                    );
                    $stripe->customers->update(
                        $userClient->stripe_id,
                        ['invoice_settings' => ['default_payment_method' => $sourceCreate->id]]
                    );
                    $charge = $stripe->charges->create([
                        'amount' => $amountToCharge * 100,
                        'currency' => 'usd',
                        'customer' => $userClient->stripe_id,
                        'source' => $sourceCreate->id,
                        'description' => 'Buds Payments.',
                    ]);
                } else {

                    if ($data['type'] == 'cc') {
                        if (isset($request['card_default_payment_id']) && !empty($request['card_default_payment_id'])) {
                            $charge = $stripe->charges->create([
                                'amount' => $amountToCharge * 100,
                                'currency' => 'usd',
                                'customer' => $userClient->stripe_id,
                                'source' => $request['card_default_payment_id'],
                                'description' => 'Buds Payments.',
                            ]);
                        } else {
                            $sourceCreate = $stripe->customers->createSource(
                                $userClient->stripe_id,
                                ['source' => $data['stripeToken']]
                            );
                            $stripe->customers->update(
                                $userClient->stripe_id,
                                ['invoice_settings' => ['default_payment_method' => $sourceCreate->id]]
                            );
                            $charge = $stripe->charges->create([
                                'amount' => $amountToCharge * 100,
                                'currency' => 'usd',
                                'customer' => $userClient->stripe_id,
                                'source' => $sourceCreate->id,
                                'description' => 'Buds Payments.',
                            ]);
                        }
                    }
                }
                $user_package_payment = new UserPackagePayment();
                // 'user_package_id', 'type', 'quantity', 'amount', 'payment_date', 'description', 'transection_id', 'attachment'
                $fillable = $user_package_payment->getFillable();
                foreach ($fillable as $columnName) {
                    if ($columnName == 'attachment') {
                        if (isset($data['attachment']) && $data['attachment']) {
                            $user_package_payment->attachment = (new Helpers())->uploadFile($data['attachment'], 'transections');
                        }
                    } else {
                        if ($columnName == 'payment_date' && $data['type'] == 'other') {
                            if (isset($data[$columnName]) && $data[$columnName]) {
                                $user_package_payment[$columnName] = $data[$columnName];
                            }
                        } else if ($columnName == 'payment_date' && $data['type'] == 'cc') {
                            $user_package_payment[$columnName] = today();
                        } else {
                            if (isset($data[$columnName]) && $data[$columnName]) {
                                $user_package_payment[$columnName] = $data[$columnName];
                            }
                        }
                    }
                }
                if (isset($charge->id)) {
                    $user_package_payment->transection_id = $charge->id;
                }
                $user_package_payment->save();
                $user_package_payment_id = $user_package_payment->id;

                $failedPayments = Delivery::where('user_package_id', $data['user_package_id'])->where('status', 'Failed')->get();

                if (!empty($failedPayments)) {
                    $cnt = 1;
                    foreach ($failedPayments as $delivery) {
                        if ($cnt <= $request['quantity']) {
                            $delivery->user_package_payment_id = $user_package_payment_id;
                            $delivery->status = 'Paid';
                            $delivery->update();
                            $cnt++;
                        }
                    }
                }
                return redirect()->route('admin.users.index')->with('success', 'User Payment Successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function package_detail(Request $request)
    {
        $packages = Package::whereId($request->packageId)->first();
        return response()->json(['success' => true, 'packages' => $packages]);
    }

    public function user_package_detail(Request $request)
    {
        $packages = UserPackage::whereId($request->user_package_id)->first();
        return response()->json(['success' => true, 'packages' => $packages]);
    }
    public function getFinalStatusAttribute()
    {
        if ($this->attributes['deactivated'] === 1) {
            $this->finalStatus = "DEACTIVATED";
        } else {
            $this->finalStatus = "ACTIVE";
        }
        return $this->finalStatus;
    }

    public function destroy($id)
    {
        $user = User::whereId($id)->first();
        if ($user->delete()) {
            return redirect()->back()->with(['success' => 'User Deleted Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }

    public function restore($id)
    {
        $user = User::withTrashed()->whereId($id)->first();
        if ($user->restore()) {
            return redirect()->back()->with(['success' => 'User Restored Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
}
