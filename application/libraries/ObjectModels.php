<?php

class ObjectModels {
  static function getName() {
    return "ObjectModels";
  }
}

class Candidate {
  var $firstName;
  var $lastName;
  var $middleName;
  var $contestingFor;
  var $code;
  var $image;
  var $id;
  /**
   * [__construct description]
   * @param [type] $firstName     [description]
   * @param [type] $lastName      [description]
   * @param [type] $middleName    [description]
   * @param [type] $contestingFor [description]
   */
  function __construct($firstName, $lastName, $middleName, $contestingFor) {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->middleName = $middleName;
    $this->contestingFor = $contestingFor;
    $ci =& get_instance();
    $ci->load->helper('string');
    $this->code = strtoupper(random_string('alnum', 5));
    $this->image = strtoupper(random_string('alnum', 10));
  }
  function getImageFileName() {
    return $this->image . ".jpg";
  }
  /**
   * [getArray description]
   * @return [type] [description]
   */
  function getArray() {
    return array("first_name"=>$this->firstName, "last_name"=>$this->lastName,
    "middle_name"=>$this->middleName, "contesting_for"=>$this->contestingFor,
    "code"=>$this->code, "image"=>$this->image);
  }
  /**
   * [absorbArray description]
   * @param  [type] $array [description]
   * @return [type]        [description]
   */
  function absorbArray($array) {
    $this->id = $array['id'];
    $this->firstName = $array['first_name'];
  }
}
?>
