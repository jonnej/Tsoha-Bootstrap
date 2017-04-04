<?php

  class TopicController extends BaseController{

    public static function show($id){
      $topic = Topic::find($id);
      $messages = Message::findByTopic($id);
      Kint::dump($topic);
      Kint::dump($messages);
      View::make('topic/show.html', array('messages' => $messages, 'topic' => $topic));
    }

    public static function newTopic(){

      View::make('topic/new.html');
    }

    public static function edit($id){
      $topic = Topic::find($id);
      $firstMessage = Topic::firstTopicMessage($id);
      Kint::dump($topic);
      Kint::dump($firstMessage);
      View::make('topic/edit.html', array('topic' => $topic, 'firstMessage' => $firstMessage));
    }

    public static function store(){
      $params = $_POST;

      $attributes = array(
        'area_id' => $params['area_id'],
        'player_id' => $params['player_id'],
        'name' => $params['name'],
        'msgtext' => $params['msgtext']
      );

      $topic = new Topic($attributes);
      $errors = $topic->errors();


      if(strlen($attributes['msgtext']) < 1 || strlen($attributes['msgtext']) > 1000){
        $errors[] = 'Viestin pituus pitää olla vähintään 1 ja enintään 1000 merkkiä';
      }

      Kint::dump($errors);

      if(count($errors) == 0){
        $topic->save();
        $message = new Message(array(
          'player_id' => $params['player_id'],
          'topic_id' => $topic->id,
          'msgtext' => $params['msgtext'],
        ));
        $message->save();

        Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi topic luotu!'));

      }else{
        View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes));
      }

    }

    public static function update($id){
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'area_id' => $params['area_id'],
        'player_id' => $params['player_id'],
        'name' => $params['name'],
        'msgtext' => $params['msgtext']
      );

      $topic = new Topic($attributes);
      $errors = $topic->errors();

      if(strlen($attributes['msgtext']) < 1 || strlen($attributes['msgtext']) > 1000){
        $errors[] = 'Viestin pituus pitää olla vähintään 1 ja enintään 1000 merkkiä';
      }
      $msgAttributes = array(

      )
      if(count($errors) == 0){
        $topic->update($id);
        $message = new Message(array(
          'player_id' => $params['player_id'],
          'topic_id' => $topic->id,
          'msgtext' => $params['msgtext'],
        ));
        $message->update();

        Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi topic luotu!'));

      }else{
        View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes));
      }
    }


  }
