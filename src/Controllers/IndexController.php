<?php

    namespace App\Controllers;

    
    use App\Registry;

class IndexController {

        public function index()
        {
            $users = Registry::get('database')->selectAll('users');
            
            return view('index', compact('users'));
        }
    }