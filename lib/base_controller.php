<?php

  class BaseController{

    public static function get_player_logged_in(){

    if(isset($_SESSION['player'])){
      $player_id = $_SESSION['player'];

      $player = Player::find_by_id($player_id);

      return $player;
    }
    return null;
    }

    public static function player_logged_in(){
      if (!isset($_SESSION['player'])){
        Redirect::to('/login', array('message' => 'Teidän täytyy kirjautua katsoaksenne salaisuuksia!'));
      }
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
