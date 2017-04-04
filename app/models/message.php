<?php

 class Message extends BaseModel{

   public $id, $player_id, $topic_id, $msgtext, $added, $modified;

   public function __construct($attributes){
     parent::__construct($attributes);
    //  $this->$validators = array('validate_msgtext');
 }

 public function save(){

   $query = DB::connection()->prepare('INSERT INTO Message (player_id, topic_id, msgtext) VALUES (:player_id, :topic_id, :msgtext) RETURNING topic_id');
   $query->execute(array('player_id' => $this->player_id, 'topic_id' => $this->topic_id, 'msgtext' => $this->msgtext));
   $row = $query->fetch();
   $this->topic_id = $row['topic_id'];

 }

 public function update($id, $attributes){
   $query = DB::connection()->prepare('UPDATE Message SET msgtext VALUES :msgtext WHERE id = :id RETURNING id');
   $query->execute(array('msgtext' => $attributes['msgtext']));
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

     if(strlen(preg_replace('/\s+/', '', $this->name)) < 1){
       $errors[] = 'Viestin pituus vähintään 1 merkki';
     }

     if(strlen($this->name) > 1000){
       $errors[] = 'Viestin pituus enintään 1000 merkkiä';
     }

     return $errors;
   }
 }
