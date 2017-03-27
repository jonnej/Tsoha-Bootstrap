<?php

 class Message extends BaseModel{

   public static function all(){

     $query = DB::connection()->prepare('SELECT * FROM Message');
     $query->execute();
     $rows = $query->fetchAll();
     $messages = array();

     foreach($rows as $row){
       $messages[] = new Message(array(
       'id' => $row['id'],
       'player_id' => $row['player_id'],
       'topic_id' => $row['topic_id'],
       'msgtext' => $row['msgtext'],
       'added' => $row['added']
     ));
     }

     return $messages;
   }

   public static function findByTopic($topic_id){
     $query = DB::connection()->prepare('SELECT * FROM Message WHERE topic_id = :topic_id');
     $query->execute(array('topic_id' => $topic_id));
     $rows = $query->fetchAll();
     $messages = array();

     foreach($rows as $row){
       $messages[] = new Message(array(
       'id' => $row['id'],
       'player_id' => $row['player_id'],
       'topic_id' => $row['topic_id'],
       'msgtext' => $row['msgtext'],
       'added' => $row['added']
     ));
     }

     return $messages;
   }
 }
