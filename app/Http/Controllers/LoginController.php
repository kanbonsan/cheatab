<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\EmailVerify;
use App\Mail\VerifyEmail;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return response()->json(['authenticated' => true]);
        } else {
            return response()->json(['authenticated' => false], 401);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['unique:users', 'required'],
            'password' => ['required'],
        ]);

        $user = new User;
        $emailVerify = new EmailVerify;

        try {

            DB::transaction(function () use ($credentials, $user, $emailVerify) {

                $user->name = $credentials['name'];
                $user->email = $credentials['email'];
                $user->password = Hash::make($credentials['password']);
                $user->save();

                $emailVerify->verify_key = implode(Arr::random([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 6));
                $emailVerify->user_id = $user->id;
                $emailVerify->save();
            });

            $data = [
                "name" => $user->name,
                "email" => $user->email,
                "verify_key" => $emailVerify->verify_key,
                "datetime" => $emailVerify->created_at,
            ];

            Mail::to($user->email)->send(new VerifyEmail($data));

            return response()->json([$user, $emailVerify, $data]);
        } catch (Exception $e) {

            return response()->json(["error" => "登録に失敗しました.", "message" => $e], 402);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return response()->json(['authenticated' => false]);
    }

    /**
     * ログイン状態を定期的に取得する目的
     */
    public function loggedIn(Request $request)
    {
        return response()->json([
            'authenticated' => true,
            'user' => $request->user()
        ]);
    }

    public function confirmEmailVerify(Request $request){

        $user = $request->user();
        $userId = $user->id;
        $key = $request->key;

        $verify = EmailVerify::where('user_id', $userId)->first();

        if( $key === $verify->verify_key){
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json('verified');
        } else {
            return response()->json('unverified');
        }
    }
}
