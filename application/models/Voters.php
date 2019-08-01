<?php
class Voters extends CI_Model {
  function addVoter($voter) {
    return $this->db->insert("voters", array("identity_key"=>$voter));
  }
  function getVoters() {
    return $this->db->get("voters")->result_array();
  }
  function deleteVoterById($id) {
    return $this->db->delete("voters", array("id"=>$id));
  }
  function deleteVoterByPhoneNumber($phoneNumber) {
    return $this->db->delete("voters", array("identity_key"=>$phoneNumber));
  }
}
?>
