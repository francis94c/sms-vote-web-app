<?php
class Preferences extends CI_Model {

  public function __construct() {
    $this->load->database();
  }

  public function getPreference($key) {
    $this->where("key_name", $key);
    $query = $this->get("preferences");
    return $query->result()[0]->key_value;
  }

  public function setPreference($key, $value) {
    $this->where("key_name", $key);
    return $this->update("preferences", array("key_value"=>$value));
  }

  private function createPreference($key, $value) {
    return $this->db->insert("preferences", array("key_name"=>$key, "key_value"=>$value));
  }

}
?>
