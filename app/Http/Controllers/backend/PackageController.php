<?php

namespace App\Http\Controllers\backend;

use App\Http\Libraries\Helpers;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::get();
        return view('backend.packages.index', compact('packages'));
    }
    public function create()
    {
        return view('backend.packages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required',
            'image' => 'required',
            'thumbnail' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->with('error', $error);
        } else {
            $data = $request->except(['_method', '_token']);
            $package = new Package();

            $fillable = $package->getFillable();
            foreach ($fillable as $columnName) {
                if ($columnName == 'image') {
                    if (isset($data['image']) && $data['image']) {
                        $package->image = (new Helpers())->uploadFile($data['image'], 'packages');
                    }
                } else if ($columnName == 'thumbnail')  {
                    if (isset($data['thumbnail']) && $data['thumbnail']) {
                        $package->thumbnail = (new Helpers())->uploadFile($data['thumbnail'], 'packages');
                    }
                } else {
                    if ($data[$columnName] != $package[$columnName]) {
                        $package[$columnName] = $data[$columnName];
                    }
                }
            }
            $package->save();
            return redirect()->route('admin.packages.index')->with('success', 'User Created Successfully.');
        }
    }

    public function show(Package $package)
    {
        //
    }

    public function edit(Request $request, $slug)
    {
        $package = Package::where('slug', $slug)->first();
        return view('backend.packages.edit', compact('package', 'package'));
    }

    public function update(Request $request, $slug)
    {
        $package = Package::where('slug', $slug)->first();
        $fillable = $package->getFillable();
        try {
            $rules = ['title' => 'required', 'type' => 'required'];
            $messages = [];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->back()->with('error', $error)->withErrors($validator)->withInput();
            } else {
                $data = $request->except(['_method', '_token']);
                foreach ($fillable as $columnName) {
                    if (isset($data[$columnName]) && $data[$columnName]) {
                        if ($data[$columnName] != $package[$columnName]) {
                            if ($columnName == 'image') {
                                $package->image = (new Helpers())->uploadFile($data['image'], 'packages');
                            }else if ($columnName == 'thumbnail') {
                                $package->thumbnail = (new Helpers())->uploadFile($data['thumbnail'], 'packages');
                            }
                            else {
                                $package[$columnName] = $data[$columnName];
                            }
                        }
                    }

                }
                if ($package->save()) {
                    return redirect()->route('admin.packages.index', $package->slug)->with('success', 'User Updated Successfully.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong.");
        }
    }

    public function destroy(Package $package)
    {
        //
    }
}
