<?php

  class PlayerController extends BaseController{

    public static function login(){
      if(isset($_SESSION['player'])) {
        Redirect::to('/area', array('message' => 'Olet jo kirjautunut sisään'));
      }
      View::make('player/login.html');
    }

    public static function register(){
      if(isset($_SESSION['player'])) {
        Redirect::to('/area', array('message' => 'Olet jo kirjautunut sisään. Kirjaudu ulos tehdäksesi uusi nimimerkki'));
      }
      View::make('player/register.html');
    }

    public static function index(){
      self::player_logged_in();
      $players = Player::all();
      View::make('player/index.html', array('players' => $players));
    }

    public static function show($id){
      self::player_logged_in();
      $player = Player::find_by_id($id);
      if($player == null){
        Redirect::to('/area', array('message' => 'Käyttäjää ei ole olemassa'));
      }
      $messages = Player::find_all_sent_messages($id);

      View::make('player/show.html', array('player' => $player, 'messages' => $messages));
    }

    public static function logout(){

      $_SESSION['player'] = null;
      $_SESSION['player_admin'] = null;
      $_SESSION['topic_id'] = null;
      $_SESSION['area_id'] = null;
      Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }


    public static function handle_login(){
      $params = $_POST;

    $player = Player::authenticate($params['nickname'], $params['password']);

    if(!$player){
      View::make('player/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nickname' => $params['nickname']));
    }else{
      $_SESSION['player'] = $player->id;
      $_SESSION['player_admin'] = $player->admin;

      Redirect::to('/area', array('message' => 'Tervetuloa takaisin keskustelemaan ' . $player->nickname . '!'));
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

        Redirect::to('/login', array('message' => 'Uusi käyttäjä luotu! Tervetuloa! Kirjautukaa sisään olkaa hyvä'));
      }else{
        View::make('player/register.html', array('errors' => $errors, 'attributes' => $attributes));
      }

    }

    public static function destroy($id){
      $message = new Player(array('id' => $id));
      $message->destroy($id);

      Redirect::to('/player', array('message' => 'Käyttäjä poistettiin onnistuneesti'));
    }

  }
