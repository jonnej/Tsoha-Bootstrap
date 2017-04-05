<?php

  class Player extends BaseModel{

    public $id, $nickname, $password, $created, $admin;

    public function __construct($attributes){
      parent::__construct($attributes);
  }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Player (nickname, password) VALUES (:nickname, :password) RETURNING id');
      $query->execute(array('nickname' => $this->nickname, 'password' => $this->password));
      $row = $query->fetch();
      $this->id = $row['id'];

    }

    public function find_by_id($id){
      $query = DB::connection()->prepare('SELECT * FROM Player WHERE id = :id');
      $query->execute(array('id' => $id));
      $row = $query->fetch();

      if($row){
        $player = new Player(array(
          'id' => $row['id'],
          'nickname' => $row['nickname'],
          'password' => $row['password'],
          'created' => $row['created'],
          'admin' => $row['admin']
        ));
        return $player;
      }
      return null;
    }

    public function authenticate(){

      $query = DB::connection()->prepare('SELECT * FROM Player WHERE nickname = :nickname AND password = :password LIMIT 1');
      $query->execute(array('nickname' => $nickname, 'password' => $password));
      $row = $query->fetch();
      if($row){
        $player = $this->find_by_id($row['id']);
        return $player;
      }else{
        return null;
      }
    }

  }
