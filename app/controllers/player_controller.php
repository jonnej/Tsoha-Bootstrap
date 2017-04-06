<?php

  class PlayerController extends BaseController{

    public static function login(){
      View::make('player/login.html');
    }

    public static function register(){
      View::make('player/register.html');
    }

    public static function show($id){
      $player = Player::find_by_id($id);
      $messages = Player::find_all_sent_messages_by_id($id);

      View::make('player/show.html', array('player' => $player, 'messages' => $messages));
    }

    public static function handle_login(){
      $params = $_POST;

    $player = Player::authenticate($params['nickname'], $params['password']);

    if(!$player){
      View::make('player/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nickname' => $params['nickname']));
    }else{
      $_SESSION['player'] = $player->id;

      Redirect::to('/area', array('message' => 'Tervetuloa takaisin keskustelemaan' . $player->nickname . '!'));
    }
  }

    public static function store(){
      $params = $_POST;

      $attributes = array(
        'nickname' => $params['nickname'],
        'password' => $params['password'],
      );
      $player = new Player($attributes);
      $errors = $player->errors();

      if(count($errors) == 0){
        $player->save();

        Redirect::to('/area', array('message' => 'Uusi käyttäjä luotu! Tervetuloa!'));
      }else{
        View::make('player/register.html', array('errors' => $errors, 'attributes' => $attributes));
      }

    }

  }
