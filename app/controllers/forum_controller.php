<?php

  class ForumController extends BaseController{

    public static function index(){
      View::make('forum/frontpage.html');
    }

    public static function search(){
      self::player_logged_in();
      View::make('forum/search.html');
    }

    public static function search_results(){
      self::player_logged_in();
      $params = $_POST;
      $players = array();
      $topics = array();
      if(isset($params['nick_search'])) {
      $players = Player::find_by_nickname($params['nick_search']);
      }
      if(isset($params['topic_search'])) {
      $topics = Topic::find_by_name($params['topic_search']);
      }

      Kint::dump($players);
      Kint::dump($topics);
      View::make('forum/search_results.html', array('topics' => $topics, 'players' => $players));

    }




  }
