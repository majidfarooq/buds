<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MercurySeries\Flashy\Flashy;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('frontend.user.password.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        require base_path("vendor/autoload.php");
        $data = [];
        $data['request'] = $request->All();
        $validator = Validator::make($request->all(), [
            'email' => [
                'required', function ($attribute, $value, $fail) {
                    if (!User::where('email', $value)->first()) {
                        $fail('Email not found');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            Flashy::error('Email not found');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where('email', $request->email)->first();
            $user->update([
                'remember_token' => Str::random(60),
            ]);
            $name = $user->first_name ? $user->name : '';
            $attributes['name'] = 'Hello' . ' ' . $name . ',';
            $attributes['content'] = 'Click the link to get back your "' . config('app.name') . '" Account.';
            $attributes['token'] = $user->remember_token;
            $attributes['to'] = $request->email;
            $attributes['from'] = 'developer@dev2.ferozitech.com';
            $attributes['subject'] = 'Reset The Password of "' . config('app.name') . '" Account.';
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'mail.dev2.ferozitech.com';
                $mail->SMTPAuth = true;
                $mail->Username = "dev_test@dev2.ferozitech.com";
                $mail->Password = "Ftech3!3";
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom($attributes['from'], config('app.name'));
                $mail->addAddress($attributes['to'], config('app.name'));
                $mail->addCC('developer@dev2.ferozitech.com');
                $mail->addBCC('engrgsyed@gmail.com');
                $mail->addReplyTo($attributes['from'], config('app.name'));
                $mail->isHTML(true);
                $mail->Subject = 'Reset The Password of  "' . config('app.name') . '" Account.';
                $mail->Body = "<p>Reset The Password of  '" . config('app.name') . "' Account <a href=" . route('password.reset', $attributes['token']) . ">Click here to Reset The Password of your Account</a></p>";
                if (!$mail->send()) {
                    return false;
                } else {
                    Flashy::success('Email Sent . Check your inbox');
                }
            } catch (Exception $e) {
                Flashy::error('Message could not be sent');
                return back()->with('error', 'Message could not be sent.');
            }
        }
        Flashy::success('Please check your email');
        return redirect()->route('home');
    }

    public function showResetForm($token)
    {
        $user = User::where('remember_token', $token)->first();
        if (!isset($user)) {
            abort(404);
        }
        return view('frontend.user.password.update', compact('user'));
    }

    public function reset(Request $request)
    {
        $user = User::whereId($request->userId)->first();
        if (isset($user)) {
            $data = [];
            $data['request'] = $request->All();
            $validator = Validator::make($request->all(), [
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:30',
                    'confirmed',
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $user->update([
                    'password' => Hash::make($data['request']['password']),
                    'remember_token' => null
                ]);
                Flashy::success('Your Password Has been Changed Please Login with new Password');
                return redirect()->route('home');
            }
        }
    }
}
