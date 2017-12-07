<?php
class SMS extends CI_Model {
  function sendSMS($voter, $message) {
    return $this->db->insert("to_send", array("_to"=>$voter, "message"=>$message));
  }
  function deleteSMS($voter) {
    return $this->db->delete("to_send", array("_to"=>$voter));
  }
  function getMessages() {
    return $this->db->get("to_send")->result_array();
  }
}
?>
