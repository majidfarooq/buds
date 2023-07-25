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

class UserController extends Controller
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

    public function show($slug)
    {
        $user = User::withTrashed()->whereSlug($slug)->with('user_packages.payments', 'user_packages.package', 'user_packages.deliveries.delivery_day')->first();
        $paymentMethods = '';
        $customerStripe = '';
        if (isset($user->stripe_id) && !empty($user->stripe_id)) {
            $customerStripe = $this->StripeHelper->getCustomer($user->stripe_id);
            $paymentMethods = $this->StripeHelper->paymentMethods($user->stripe_id);
        }
        return view('backend.users.show', compact('user', 'paymentMethods', 'customerStripe'));
    }

    public function import_csv()
    {
        // dd(asset('public/assets/backend/csv/buds_customers.csv'));
        if (($open = fopen(asset('public/assets/backend/csv/buds_customers.csv'), "r")) !== FALSE) {
            // dd('here');

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $users[] = $data;
            }

            fclose($open);
        } else {
            dd('cannot find file');
        }
        foreach ($users as $user) {
            $current_user = new User();
            if ($user[0] == '') {
                $user[0] = 'Mr';
            }
            if ($user[9] == '') {
                $user[9] = null;
            }
            $current_user['first_name'] = $user[0];
            $current_user['last_name'] = $user[1];
            $current_user['recipient_name'] = $user[0] . '' . $user[1];
            $current_user['recipient_phone'] = $user[2];
            $current_user['phone'] = $user[2];
            $current_user['email'] = $user[3];
            $current_user['billing_address1'] = $user[4];
            $current_user['billing_address2'] = $user[5];
            $current_user['billing_city'] = $user[6];
            $current_user['billing_state'] = $user[7];
            $current_user['billing_zip'] = $user[8];
            $current_user['delivery_address1'] = $user[4];
            $current_user['delivery_address2'] = $user[5];
            $current_user['delivery_city'] = $user[6];
            $current_user['delivery_state'] = $user[7];
            $current_user['delivery_zip'] = $user[8];
            $current_user['stripe_id'] = $user[9];
            $current_user->save();
        }
        dd('User Imported Successfully');
    }
    public function create()
    {
        return view('backend.users.create');
    }
    public function transactions()
    {
        return view('backend.transaction.create');
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
                    $data["delivery_lat"] = $data["billing_lat"];
                    $data["delivery_long"] = $data["billing_long"];
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
                // dd();
                // dd($data);
                if (isset($data['same_as_billing_address']) && $data['same_as_billing_address'] == 'on') {
                    $data["delivery_address1"] = $data["billing_address1"];
                    $data["delivery_address2"] = $data["billing_address2"];
                    $data["delivery_city"] = $data["billing_city"];
                    $data["delivery_state"] = $data["billing_state"];
                    $data["delivery_zip"] = $data["billing_zip"];
                    $data["delivery_coordinates"] = $data["billing_coordinates"];
                    $data["delivery_lat"] = $data["billing_lat"];
                    $data["delivery_long"] = $data["billing_long"];
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
                    return redirect()->route('admin.users.index', $user->slug)->with('success', 'User Updated Successfully.');
                }
            }
        } catch (\Exception $e) {
            dd($e);

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
                foreach ($fillable as $columnName) {
                    if (isset($data[$columnName]) && $data[$columnName]) {
                        $userpackage[$columnName] = $data[$columnName];
                    }
                }
                $userpackage->save();
                if ($data['paid_via'] == 'other') {
                    $user_package_payment = new UserPackagePayment();
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
                    if (isset($request['card_default_payment_id']) && !empty($request['card_default_payment_id'])) {
                    } else {
                        if (empty($userClient->stripe_id)) {
                            $user = $this->StripeHelper->createCustomer($userClient->email);
                            $userClient->stripe_id = $user->id;
                            $userClient->update();
                            $sourceCreate = $this->StripeHelper->createSource($user->id, $data['stripeToken']);
                            $this->StripeHelper->updateDefaultMethod($userClient->stripe_id, $sourceCreate->id);
                        } else {
                            $sourceCreate = $this->StripeHelper->createSource($userClient->stripe_id, $data['stripeToken']);
                            $this->StripeHelper->updateDefaultMethod($userClient->stripe_id, $sourceCreate->id);
                        }
                    }
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
        if (isset($UserPackage->user->stripe_id) && !empty($UserPackage->user->stripe_id)) {
            $customerStripe = $this->StripeHelper->getCustomer($UserPackage->user->stripe_id);
            $paymentMethods = $this->StripeHelper->paymentMethods($UserPackage->user->stripe_id);
        }
        return view('backend.users.assign_total_credit', compact('UserPackage', 'paymentMethods', 'customerStripe'));
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
                $userClient = User::whereid($data['user_id'])->first();
                if ($data['type'] == 'cc') {
                    if (empty($userClient->stripe_id)) {
                        $user = $this->StripeHelper->createCustomer($userClient->email);
                        $userClient->stripe_id = $user->id;
                        $userClient->update();
                        $sourceCreate = $this->StripeHelper->createSource($user->id, $data['stripeToken']);
                        $sourceId = $sourceCreate->id;
                    } else {
                        if ($request->card_default_payment_id == 'new_card') {
                            $sourceCreate = $this->StripeHelper->createSource($userClient->stripe_id, $data['stripeToken']);
                            $sourceId = $sourceCreate->id;
                        } else {
                            $sourceId = $request->card_default_payment_id;
                        }
                    }
                    $charge = $this->StripeHelper->createCharge($amountToCharge, $userClient->stripe_id, $sourceId);
                    $stripe_t_id = $charge->id;
                }
                $user_package_payment = new UserPackagePayment();
                $fillable = $user_package_payment->getFillable();
                if (isset($stripe_t_id) && !empty($stripe_t_id)) {
                    $data['transection_id'] = $stripe_t_id;
                }
                foreach ($fillable as $columnName) {
                    if ($columnName == 'attachment') {
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
            return redirect()->back()->with(['success' => 'User Deactivated Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }
    public function deactivate($id)
    {
        $user = User::whereId($id)->update(['deactivated' => 1]);
        if ($user) {
            $upg = UserPackage::where('user_id', $id)->delete();
            return redirect()->back()->with(['success' => 'User Deactivated Successfully..!']);
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }

    public function activate($id)
    {
        $user = User::whereId($id)->update(['deactivated' => 0]);
        if ($user) {
            return redirect()->back()->with(['success' => 'User Activated Successfully..!']);
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
