<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SocialAuthService;

class SocialiteController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirect($provider)
    {
        return $this->socialAuthService->redirect($provider);
    }

    public function callback($provider)
    {
        $user = $this->socialAuthService->handleCallback($provider);

        Auth::login($user);

        return redirect('/');    
    }
}
