<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    
    public function index() {
        try{
            Gate::authorize("view-any");
            return view("home");
        }catch(AuthorizationException $e){
            return view("layout");
        }
    }
}
