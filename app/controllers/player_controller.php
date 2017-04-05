<?php

  class PlayerController extends BaseController{

    public static function login(){
      View::make('login.html');
    }

    public static function handle_login(){
      $params = $_POST;

    $player = Player::authenticate($params['nickname'], $params['password']);

    if(!$player){
      View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
    }else{
      $_SESSION['player'] = $player->id;

      Redirect::to('/area', array('message' => 'Tervetuloa takaisin keskustelemaan' . $player->name . '!'));
    }
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
