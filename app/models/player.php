<?php

  class Player extends BaseModel{

    public $id, $nickname, $password, $created, $admin;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validate_nickname', 'validate_password');
  }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Player (nickname, password) VALUES (:nickname, :password) RETURNING id');
      $query->execute(array('nickname' => $this->nickname, 'password' => $this->password));
      $row = $query->fetch();
      $this->id = $row['id'];

    }

    public static function find_by_id($id){
      $query = DB::connection()->prepare('SELECT * FROM Player WHERE id = :id');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row){
        $player = new Player(array(
          'id' => $row['id'],
          'nickname' => $row['nickname'],
          'password' => $row['password'],
          // 'created' => $row['created'],
          'admin' => $row['admin']
        ));
        return $player;
      }
      return null;
    }

    public static function find_by_nickname($nickname){
      $query = DB::connection()->prepare('SELECT * FROM Player WHERE nickname = :nickname');
      $query->execute(array('nickname' => $nickname));
      $row = $query->fetch();

      if($row){
        $player = new Player(array(
          'id' => $row['id'],
          'nickname' => $row['nickname'],
          'password' => $row['password'],
          // 'created' => $row['created'],
          'admin' => $row['admin']
        ));
        return $player;
      }
      return null;
    }

    public static function find_all_sent_messages_by_id($player_id){
      $query = DB::connection()->prepare('SELECT * FROM Message WHERE player_id = :player_id ORDER BY added DESC');
      $query->execute(array('player_id' => $player_id));
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

    public static function sent_messages_count_by_id($player_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE player_id = :player_id');
      $query->execute(array('player_id' => $player_id));
      $result = $query->fetch();

      echo $result[0];
    }

    public function authenticate($nickname, $password){

      $query = DB::connection()->prepare('SELECT * FROM Player WHERE nickname = :nickname AND password = :password LIMIT 1');
      $query->execute(array('nickname' => $nickname, 'password' => $password));
      $row = $query->fetch();
      if($row){
        $player = self::find_by_id($row['id']);
        return $player;
      }else{
        return null;
      }
    }

    public function validate_nickname(){
      $errors = array();

      if(strlen(preg_replace('/\s+/', '', $this->nickname)) < 3){
        $errors[] = 'Käyttäjänimen pitää olla vähintään 3 merkkiä pitkä';
      }

      if(strlen($this->nickname) > 20){
        $errors[] = 'Käyttäjänimen maksimi pituus on 20 merkkiä';
      }

      if($this->find_by_nickname($this->nickname)) {
        $errors[] = 'Käyttäjänimi on jo käytössä, valitse jokin toinen';
      }

      return $errors;
    }

    public function validate_password(){
      $errors = array();

      if(strlen(preg_replace('/\s+/', '', $this->password)) < 5){
        $errors[] = 'Salasanan pitää olla vähintään 5 merkkiä pitkä';
      }

      if(strlen($this->password) > 50){
        $errors[] = 'Salasanan maksimi pituus on 50 merkkiä';
      }

      if(!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', $this->password)){
        $errors[] = 'Salasanassa pitää olla vähintään yksi kirjain ja yksi numero';
      }

      return $errors;

    }

  }
