<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Setting;
use App\Models\UserPackage;
use App\Models\Delivery;
use App\Models\UserPackagePayment;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



class AdminController extends Controller
{
    use AuthenticatesUsers;
    public function changePassword(Request $request)
    {
        $data = [];
        $data['request'] = $request->All();
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, \Illuminate\Support\Facades\Auth::user()->password)) {
                        $fail('Current Password didn\'t match');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'confirmed',
                'different:current_password',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($data['request']['password'])
            ]);
            Auth::logout();
            Flashy::success('Password Has Changed Please Login with new Password');
            return redirect()->route('admin.login');
        }
    }

    public function basicInformation(Request $request)
    {
        $admin = Admin::where('id', $this->guard()->user()->id)->first();
        if (Auth::Check()) {
            $request_data = $request->only('name', 'image');
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'mimes:jpg,bmp,png',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if ($request->hasFile('image') == null) {
                    $content = $admin->image;
                } else {
                    $imageFile = sprintf('admin_%s.jpg', random_int(1, 1000));
                    $path = $request->file('image')->storeAs('/images', $imageFile, 'public');
                    $content = '/storage/app/public/' . $path;
                }
                $admin->name = $request_data['name'];
                $admin->image = $content;
                if ($admin->update()) {
                    return redirect()->back()->with('success', 'Your Account Information Changed');
                }
            }
        }
    }
    protected function dashboard()
    {
        $this_week_start = Carbon::now()->startOfWeek();
        $this_week_end = Carbon::now()->endOfWeek();
        $last_week_start = Carbon::now()->subWeek()->startOfWeek();
        $last_week_end = Carbon::now()->subWeek()->endOfWeek();

        $this_month_start = Carbon::now()->startOfMonth();
        $this_month_end = Carbon::now()->endOfMonth();
        $last_month_start = Carbon::now()->startOfMonth()->subMonth();
        $last_month_end = Carbon::now()->endOfMonth()->subMonth();

        $data['delivery_count_current_week'] = Delivery::with('delivery_day')->whereHas('delivery_day', function ($q) use ($this_week_start, $this_week_end) {
            $q->whereBetween('delivery_date', [$this_week_start, $this_week_end]);
        })->where('status', '!=', 'canceled')->count();

        $data['delivery_count_last_week'] = Delivery::with('delivery_day')->whereHas('delivery_day', function ($q) use ($last_week_start, $last_week_end) {
            $q->whereBetween('delivery_date', [$last_week_start, $last_week_end]);
        })->where('status', '!=', 'canceled')->count();
        $data['total_subscriptions'] = UserPackage::where('status', 'active')->count();
        $data['subscriber_this_month'] = UserPackage::whereBetween('created_at', [$this_month_start, $this_month_end])->where('status', 'active')->count();
        $data['total_revenue_this_month'] = UserPackagePayment::whereBetween('payment_date', [$this_month_start, $this_month_end])->sum('amount');
        $data['total_revenue_this_week'] = UserPackagePayment::whereBetween('payment_date', [$this_week_start, $this_week_end])->sum('amount');

        $delivery_this_week = Delivery::with('delivery_day', 'user_package.package')
            ->whereHas('delivery_day', function ($q) use ($this_week_start, $this_week_end) {
                $q->whereBetween('delivery_date', [$this_week_start, $this_week_end]);
            })->where('status', '!=', 'canceled')->get();
        $paid_amt = 0;
        $unpaid_amt = 0;
        $recieveable_amt = 0;
        $status = '';
        foreach ($delivery_this_week as $del) {
            if ($del->status == 'Paid') {
                $paid_amt = $paid_amt + $del->user_package->package->price;
            } elseif ($del->status == 'Failed') {
                $unpaid_amt = $unpaid_amt + $del->user_package->package->price;
            } elseif ($del->status == 'Pending') {
                $recieveable_amt = $recieveable_amt + $del->user_package->package->price;
            }
        }
        $data['paid_delivery_amount_this_week'] = $paid_amt;
        $data['unpaid_delivery_amount_this_week'] = $unpaid_amt;
        $data['recieveable_delivery_amount_this_week'] = $recieveable_amt;
        // dd($status);
        $delivery_this_month = Delivery::with('delivery_day', 'user_package.package')
            ->whereHas('delivery_day', function ($q) use ($this_month_start, $this_month_end) {
                $q->whereBetween('delivery_date', [$this_month_start, $this_month_end]);
            })->where('status', '!=', 'canceled')->get();
        $paid_amt = 0;
        $unpaid_amt = 0;
        $recieveable_amt = 0;
        foreach ($delivery_this_month as $del) {
            if ($del->status == 'Paid') {
                $paid_amt = $paid_amt + $del->user_package->package->price;
            } elseif ($del->status == 'Failed') {
                $unpaid_amt = $unpaid_amt + $del->user_package->package->price;
            } elseif ($del->status == 'Pending') {
                $recieveable_amt = $recieveable_amt + $del->user_package->package->price;
            }
        }
        $data['paid_delivery_amount_this_month'] = $paid_amt;
        $data['unpaid_delivery_amount_this_month'] = $unpaid_amt;
        $data['recieveable_delivery_amount_this_month'] = $recieveable_amt;

        $revenue_group_by_month = UserPackagePayment::select(
            DB::raw('sum(amount) as amount'),
            DB::raw("DATE_FORMAT(payment_date,'%M %Y') as months")
        )->groupBy('months')->get()->toArray();

        $data['revenue_group_by_month']['x'] = '';
        $data['revenue_group_by_month']['y'] = '';
        $data['revenue_group_by_month']['total_amount']=0;
        foreach ($revenue_group_by_month as $rbm) {
            $data['revenue_group_by_month']['x'] .= $rbm['months'] . ',';
            $data['revenue_group_by_month']['y'] .= $rbm['amount'] . ',';
            $data['revenue_group_by_month']['total_amount']+=$rbm['amount'];
        }
//         dd($data['revenue_group_by_month']);
        $data['total_receivable_next_week'] = UserPackagePayment::whereBetween('payment_date', [$this_week_start, $this_week_end])->sum('amount');

        return view('backend.dashboard.dashboard', compact('data'));
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function createAdmin()
    {
        $this->checkAuthorization();
        return view('backend.admin.create');
    }
    public function editAdmin($id)
    {
        $this->checkAuthorization();
        $adminId = (new Helpers())->decrypt_string($id);
        $adminDetail = Admin::whereId($adminId)->first();
        return view('backend.admin.edit', compact('adminDetail'));
    }
    public function show($id)
    {
        $this->checkAuthorization();
        $id = (new Helpers())->decrypt_string($id);
        $admin = Admin::whereId($id)->first();
        return view('backend.admin.show', compact('admin'));
    }
    public function listSubAdmins()
    {
        $this->checkAuthorization();
        $admins = Admin::get();
        return view('backend.admin.sub_index', compact('admins'));
    }
    public function storeAdmin(Request $request)
    {
        $this->checkAuthorization();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
                'password' => 'required',
                'email' => 'unique:admins,email',
                'image' => 'mimes:jpg,jpeg,png',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                $admin = new Admin;
                if (isset($data['name']) && $data['name']) {
                    $admin->name = $data['name'];
                }
                // if (isset($data['extension']) && $data['extension']) {
                //   $admin->extension = $data['extension'];
                // }
                if (isset($data['email']) && $data['email']) {
                    $admin->email = $data['email'];
                }
                if (isset($data['role']) && $data['role']) {
                    $admin->role = $data['role'];
                }
                if (isset($data['password']) && $data['password']) {
                    $admin->password = Hash::make($data['password']);
                }
                if (isset($data['image'])) {
                    $admin->image = (new Helpers())->uploadFile($data['image'], 'admins');
                }
                $admin->save();
                $data = [
                    'admin_id' => Auth::user()->id,
                    "message" => $admin->email . " created on (" . $admin->created_at . ") and by (" . Auth::user()->email . ")",
                ];
                // $this->createOrUpdateLogs($data);
                return redirect()->route('admin.subadmins.list')->with('success', 'Admin Created Successfully.');
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect()->back()->with('error', $error);
        }
    }
    public function update(Request $request)
    {
        $this->checkAuthorization();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error);
            } else {
                $data = $request->except(['_method', '_token']);
                $admin = Admin::whereId($data['admin_id'])->first();
                $fillable = $admin->getFillable();
                $logStr = $admin->email . " updated by " . Auth::user()->email . " <br>";
                foreach ($fillable as $column) {
                    if (isset($data[$column]) && $data[$column]) {
                        if ($data[$column] != $admin[$column]) {
                            $logStr .= " updated " . $column . " from (" . $admin[$column] . ") to (" . $data[$column] . ") <br>";
                            if ($column == 'image') {
                                $admin->image = (new Helpers())->uploadFile($data['image'], 'admins');
                            } else {
                                $admin[$column] = $data[$column];
                            }
                        }
                    }
                }
                $admin->update();
                $dataforAdminUpdateLog = [
                    'admin_id' => Auth::user()->id,
                    "message" => $logStr,
                ];
                // $this->createOrUpdateLogs($dataforAdminUpdateLog);

                return redirect()->route('admin.subadmins.list')->with('success', 'Admin Updated Successfully.');
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect()->back()->with('error', $error);
        }
    }
    public function account()
    {
        return view('backend.admin.index');
    }
    public function settings()
    {
        $siteContents = Setting::all();
        foreach ($siteContents as $sc) {
            $content[$sc['field_key']] = $sc['field_value'];
        }
        return view('backend.admin.settings', compact('content', 'siteContents'));
    }
    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $val) {
            $setting_field = Setting::where('field_key', $key)->first();
            $setting_field->field_value = $val;
            $setting_field->save();
        }
        return redirect()->back()->with('success', 'Site Settings Changed successfully');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
    public static function makeEncryption($id)
    {
        return (new Helpers())->encrypt_string($id);
    }
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    protected function authenticated(Request $request, $user)
    {
        Flashy::success("Login Successful.");
        return redirect()->route('admin.dashboard');
    }
    public function checkAuthorization()
    {

        if (Auth::guard('admin')->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }
    }
    public function destroy($id)
    {
        $admin = Admin::whereNotIn('id', [$id])->where('role', 'super_admin')->first();
        if (empty($admin)) {
            return redirect()->back()->with('error', "last super admin can not be deleted");
        } else {
            $admin = Admin::whereId($id)->first();
            Storage::delete($admin->image);
            $admin->delete();
            return redirect()->back()->with('success', 'Admin Deleted Successfully.');
        }
    }


    //$2y$10$PoL4r5VQ05WJ7thly4uqU.xhBcGROwbovbljhaveg3JiGOW0XDZBG
    //$2y$10$PoL4r5VQ05WJ7thly4uqU.xhBcGROwbovbljhaveg3JiGOW0XDZBG
}
