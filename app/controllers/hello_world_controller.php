<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('frontpage.html');
    }

    public static function sandbox(){
      View::make('login.html');
    }

    public static function login(){
    View::make('login.html');
    }

    public static function register(){
    View::make('register.html');
    }

    public static function discussionareas(){
    View::make('discussionareas.html');
    }

    public static function areatopics(){
    View::make('areatopics.html');
    }

    public static function topic(){
    View::make('topic.html');
    }
}
