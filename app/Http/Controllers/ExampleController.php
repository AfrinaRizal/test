<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function generateKey()
    {
        // return str_random(32);
        return md5('afrina');
    }

    public function fooExample()
    {
        // return str_random(32);
        return 'Example Controller drom POST request';
    }

    public function getUser($id)
    {
        return 'User ID = '.$id;
    }

    public function getPost($cat1, $cat2)
    {
        return 'Category 1 = '.$cat1. ', Category 2 = '.$cat2;
    }

    public function getProfile()
    {
        // return 'Route Profile Action : '.route('profile.action');
        echo '<a href="'.route('profile.action').'">Profile Action</a>';
    }

    public function getProfileAction()
    {
        return 'Route Profile : '.route('profile');
    }
}
