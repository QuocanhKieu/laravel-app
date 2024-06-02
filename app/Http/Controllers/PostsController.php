<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index() {
        // trả ra URL string trên thanh address bar mặc cho mình đặt name là gì bên route
        $name = route('abc');
        return view('posts.index',compact('name'));
    }
}
