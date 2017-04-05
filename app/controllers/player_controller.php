<?php

  class PlayerController extends BaseController{

    public static function login(){
      View::make('login.html');
    }

    public static function handle_login(){
      
    }


    public static function store(){

      $params = $_POST;
      $player = new Player(array(
        'nickname' => $params['nickname'],
        'password' => $params['password'],

      ));

      $player->save();

      Redirect::to('/player/' . $player->id, array('message' => 'Rekisteröityminen onnistui! Tervetuloa!'));
    }

  }
