<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('frontpage.html');
    }

    public static function sandbox(){
      View::make('login.html');
    }
  }
