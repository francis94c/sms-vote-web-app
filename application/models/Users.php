<?php
class Users extends CI_Model {
  function getHash($id) {
    return $this->db->get_where("users", array("id"=>$id))->result_array()[0]["password"];
  }
  function changePassword($id, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $this->db->where("id", $id);
    return $this->db->update("users", array("password"=>$password));
  }
}
?>
