<?php

class OrderController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function getOrder()
    {
        if (Auth::check()) {
            return Redirect::to('/');
        }
        return View::make( 'pages.login' );
    }
    public function postOrder()
    {
        $user = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        if (Auth::attempt($user)) {
            return Redirect::to('/');
        }

        return Redirect::to('login')
            ->with('error', 'Nome Utente o Password non corretti.')
            ->withInput();
    }
    public function getOrders()
    {
        Auth::logout();
        return Redirect::to( 'login' );
    }

}