<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();
      $validator_errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $validator_errors[] = $validator
      }
      $errors = array_merge($errors, $validator_errors);
      return $errors;
    }

    public function validate_string_min_length($string, $length){
      $errors = array();

      if(strlen($this->$string) < $length){
        $errors[] = $string . ' pituus tulee olla vähintään ' . $length . ' merkkiä!';
      }

      return $errors;
    }

    public function validate_string_max_length($string, $length){
      $errors = array();

      if(strlen($this->$string) > $length){
        $errors[] = $string . ' pituus tulee olla enintään ' . $length . ' merkkiä!';
      }

      return $errors;
    }

    public function validate_integer_is_numeric($integer){
      $errors = array();

      if(is_numeric($this->$integer)){
        return $errors;
      }
      $errors[] = $integer . ' ei ole numeraali';
      return $errors;
    }



  }
