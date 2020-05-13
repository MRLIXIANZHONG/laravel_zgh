<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Cookie;

class ErrorController extends Controller
{
    public function error(Request $request){
        return view("system.error");
    }
}