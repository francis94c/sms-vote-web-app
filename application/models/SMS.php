<?php
class SMS extends CI_Model {
  function sendSMS($voter, $message) {
    return $this->db->insert("to_send", array("_to"=>$voter, "message"=>$message));
  }
  function sendInvalidSMS($voter, $message) {
    return $this->db->insert("invalid_to_send", array("_to"=>$voter, "message"=>$message));
  }
  function deleteSMS($voter) {
    return $this->db->delete("to_send", array("_to"=>$voter));
  }
  function deleteInvalidSMS($phone) {
    return $this->db->delete("invalid_to_send", array("_to"=>$phone));
  }
  function getMessages() {
    $messages = $this->db->get("to_send")->result_array();
    $invalids = $this->db->get("invalid_to_send")->result_array();
    for ($x = 0; $x < count($invalids); $x++) {
      $messages[] = $invalids[$x];
    }
    return $messages;
  }
}
?>
