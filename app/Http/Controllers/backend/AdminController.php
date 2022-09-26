<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helpers;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MercurySeries\Flashy\Flashy;

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

    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function createAdmin()
    {
        return view('backend.admin.create');
    }
    public function editAdmin($id)
    {
        $adminId = (new Helpers())->decrypt_string($id);
        $adminDetail = Admin::whereId($adminId)->first();
        return view('backend.admin.edit', compact('adminDetail'));
    }
    public function show($id)
    {
        $id = (new Helpers())->decrypt_string($id);
        $admin = Admin::whereId($id)->first();
        return view('backend.admin.show', compact('admin'));
    }
    public function listSubAdmins()
    {
        $admins = Admin::get();
        return view('backend.admin.sub_index', compact('admins'));
    }
    public function storeAdmin(Request $request)
    {
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


    public function dashboard()
    {
        $data['users'] = User::where('role_id', 1)->count();
        $data['vendors'] = User::where('role_id', 2)->count();
        return view('backend.dashboard.dashboard', compact('data'));
    }
    public function account()
    {
        return view('backend.admin.index');
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
        return redirect()->route('admin.home');
    }
}
