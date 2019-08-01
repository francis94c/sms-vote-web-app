<?php
/**
 * [Candidates description]
 */
class Candidates extends CI_Model {
  /**
   * [resolveCode description]
   * @param  [type] $code [description]
   * @return [type]       [description]
   */
  function resolveCode($code) {
    $this->db->where("code", $code);
    $query = $this->db->get("candidates");
    if ($query->num_rows() == 1) {
      return $query->result()[0]->id;
	  }
    return -1;
  }
  /**
   * [getCategory description]
   * @param  [type] $candidateId [description]
   * @return [type]              [description]
   */
  function getCategory($candidateId) {
    $this->db->where("id", $candidateId);
    $query = $this->db->get("candidates");
    return $query->result()[0]->contesting_for;
  }
  /**
   * [createCandidate description]
   * @param  [type] $candidate [description]
   * @return [type]            [description]
   */
  function createCandidate($candidate) {
    if ($this->session->userdata("validated")) {
      return $this->db->insert("candidates", $candidate->getArray());
    } else {
      return false;
    }
  }
  function getImageFileName($id) {
    $query = $this->db->get_where("candidates", array("id"=>$id));
    if ($query->num_rows() > 0) {
      return $query->result()[0]->image . ".jpg";
    } else {
      return "null";
    }
  }
  /**
   * [removeCandidate description]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  function removeCandidate($id) {
    $this->db->where("id", $id);
    return $this->db->delete("candidates");
  }
  /**
   * [getCandidates description]
   * @return [type] [description]
   */
  function getCandidates() {
    $query = $this->db->get("candidates");
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    return null;
  }
  function getCandidatesInCategory($cid) {
    $query = $this->db->get_where("candidates", array("contesting_for"=>$cid));
    return $query->result_array();
  }
}
?>
