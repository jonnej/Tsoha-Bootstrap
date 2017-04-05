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
      $first_message = Topic::firstTopicMessage($id);
      Kint::dump($topic);
      Kint::dump($first_message);
      View::make('topic/edit.html', array('topic' => $topic, 'first_message' => $first_message));
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
      );

      $topic = new Topic($attributes);
      $errors = $topic->errors();

      if(strlen($params['msgtext']) < 1 || strlen($params['msgtext']) > 1000){
        $errors[] = 'Viestin pituus pitää olla vähintään 1 ja enintään 1000 merkkiä';
      }

      $messageAttributes = array(
        'player_id' => $params['player_id'],
        'topic_id' => $topic->id,
        'msgtext' => $params['msgtext']
      );

      if(count($errors) == 0){
        $topic->update($id, $attributes);
        $firstmsg = Topic::firstTopicMessage();
        $msg_id = $firstmsg->id;
        $messageAttributes = array(
          'id' => $msg_id,
          'player_id' => $params['player_id'],
          'topic_id' => $topic->id,
          'msgtext' => $params['msgtext']
        );

        $message = new Message($messageAttributes);
        $firstmsg = Topic::firstTopicMessage();
        $message->update($msg_id, $messageAttributes);

        Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi topic luotu!'));

      }else{
        View::make('topic/edit.html', array('errors' => $errors, 'attributes' => $attributes));
      }
    }


  }
