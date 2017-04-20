<?php

 class Message extends BaseModel{

   public $id, $player_id, $topic_id, $msgtext, $added, $modified;

   public function __construct($attributes){
     parent::__construct($attributes);
     $this->validators = array('validate_msgtext');
 }

 public function save(){

   $query = DB::connection()->prepare('INSERT INTO Message (player_id, topic_id, msgtext) VALUES (:player_id, :topic_id, :msgtext) RETURNING topic_id');
   $query->execute(array('player_id' => $this->player_id, 'topic_id' => $this->topic_id, 'msgtext' => $this->msgtext));
   $row = $query->fetch();
   $this->topic_id = $row['topic_id'];

 }

 public function update($id, $attributes){
   $query = DB::connection()->prepare('UPDATE Message SET (player_id, topic_id, msgtext) = (:player_id, :topic_id, :msgtext) WHERE id = :id');
   $query->execute(array('id' => $id, 'player_id' => $attributes['player_id'], 'topic_id' => $attributes['topic_id'], 'msgtext' => $attributes['msgtext']));
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

   public static function findById($id){
     $query = DB::connection()->prepare('SELECT * FROM Message WHERE id = :id');
     $query->execute(array('id' => $id));

     $row = $query->fetch();

     if($row){
       $messages = new Message(array(
       'id' => $row['id'],
       'player_id' => $row['player_id'],
       'topic_id' => $row['topic_id'],
       'msgtext' => $row['msgtext'],
       'added' => $row['added'],
       'modified' => $row['modified']
     ));

     return $message;
     }

     return null;
   }

   public static function findByTopic($topic_id){
     $query = DB::connection()->prepare('SELECT * FROM Message WHERE topic_id = :topic_id ORDER BY added ASC');
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

   public function validate_msgtext(){
     $errors = array();

     if(strlen(preg_replace('/\s+/', '', $this->msgtext)) < 1){
       $errors[] = 'Viestin pituus vähintään 1 merkki';
     }

     if(strlen($this->msgtext) > 1000){
       $errors[] = 'Viestin pituus enintään 1000 merkkiä';
     }

     return $errors;
   }
 }
