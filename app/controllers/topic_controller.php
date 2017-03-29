<?php

  class TopicController extends BaseController{

    public static function show($id){
      $topic = Topic::find($id);
      $messages = Message::findByTopic($id);
      Kint::dump($topic);
      Kint::dump($messages);
      // $messages = Message::areaTopics($id);
      View::make('topic/show.html', array('messages' => $messages));
    }

    public static function newTopic(){

      View::make('topic/new.html');
    }

    public static function store(){

      $params = $_POST;
      $topic = new Topic(array(
        'area_id' => $params['area_id'],
        'player_id' => $params['player_id'],
        'name' => $params['name'],

      ));

      $topic->save();

      Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi topic luotu!'));
    }


  }
