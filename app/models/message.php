<?php

 class Message extends BaseModel{

   public $id, $player_id, $topic_id, $msgtext, $added, $modified;

   public function __construct($attributes){
     parent::__construct($attributes);
 }

 public function save(){

   $query = DB::connection()->prepare('INSERT INTO Message (player_id, topic_id, msgtext) VALUES (:player_id, :topic_id, :msgtext) RETURNING id');
   $query->execute(array('player_id' => $this->player_id, 'topic_id' => $this->topic_id, 'name' => $this->msgtext));
   $row = $query->fetch();
   $this->id = $row['id'];

 }

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
       'added' => $row['added'],
       'modified' => $row['modified']
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
