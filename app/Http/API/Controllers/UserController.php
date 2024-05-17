<?php

namespace App\Http\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    /**
     * Get autheticated user
     */
    public function me()
    {
        return Auth::user();
    }
}