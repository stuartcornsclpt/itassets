<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OfficeLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('azure')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('azure')->user();

        if($authUser = User::whereEmail($user->email)->first()){

        }else{
            $unhash = 'Test123';
            $password = Hash::make($unhash);
            $authUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
            ]);
            
            Mail::to('stuartcorns@outlook.com')->send(new \App\Mail\NewUserPassword($authUser, $unhash));

            /*  Mail::send('emails.tpl', $data, function($message){
                $message->to('stuartcorns@outlook.com', 'Stuart')->subject('Email with Laravel and AWS');
            }); */
        }
        auth()->login($authUser, false);

        return redirect('/dashboard');
    }
}
