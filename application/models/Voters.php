<?php
class Voters extends CI_Model {
  function addVoter($voter) {
    return $this->db->insert("voters", array("identity_key"=>$voter));
  }
  function getVoters() {
    return $this->db->get("voters")->result_array();
  }
  function deleteVoter($id) {
    return $this->db->delete("voters", array("id"=>$id));
  }
}
?>
