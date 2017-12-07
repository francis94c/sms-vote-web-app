<?php
/**
 * [BallotBox description]
 */
class BallotBox extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->load->model('Candidates');
  }
  /**
   * [vote description]
   * @param  [type] $voter    [description]
   * @param  [type] $codes [description]
   * @return [type]        [description]
   */
  function vote($voter, $codes) {
    $this->load->model("sms");
    $flags = array("fraud"=>0, "errors"=>0);
    $c = count($codes);
    for ($x = 0; $x < $c; $x++) {
      $cid = $this->Candidates->resolveCode($codes[$x]);
	    if ($cid == -1) {
        $flags["errors"] = $flags["errors"] + 1;
		    continue;
	    }
      if ($this->validateVoter($voter)) {
        if (!$this->castVote($this->resolveVoter($voter), $cid)) {
          log_message("error", "Fraud! Could not cast vote " . $voter . "--" . $cid);
          $flags["fraud"] = $flags["fraud"] + 1;
        }
      } else {
        log_message("error", "Fraud! Voter Not Valid " . $voter . "--" . $cid);
        $flags["fraud"] = $flags["fraud"] + 1;
        break;
      }
    }
    if ($flags["fraud"] == 0 && $flags["errors"] == 0) {
      $this->sms->sendSMS($this->resolveVoter($voter), "Your Vote(s) has been cast Succesfully.");
    } elseif ($flags["fraud"] > 0) {
      $this->sms->sendSMS($this->resolveVoter($voter), "Some or All of your votes have been deemed fraudulent.");
    } elseif ($flags["errors"] > 0) {
      $this->sms->sendSMS($this->resolveVoter($voter), "It's either you are not eligible to vote, or there was an error casting your vote(s).");
    }
    return $flags;
  }
  function clearBallotBox() {
    $this->db->empty_table("ballot_box");
  }
  function getResultForCandidate($candidate) {
    $query = $this->db->get_where("ballot_box", array("candidate"=>$candidate));
    $votes = $query->num_rows();
    $query = $this->db->get("voters");
    if ($query->num_rows() > 0) {
      $result = ($votes / $query->num_rows()) * 100;
      return round($result, 2, PHP_ROUND_HALF_EVEN);
    }
    return 0;
  }
  /**
   * [castVote description]
   * @param  [type] $voter     [description]
   * @param  [type] $candidate [description]
   * @return [type]            [description]
   */
  private function castVote($voter, $candidate) {
    $data = array("candidate"=>$candidate, "voter"=>$voter, "category"=>$this->Candidates->getCategory($candidate));
    return $this->db->insert("ballot_box", $data);
  }
  private function validateVoter($voter) {
    $query = $this->db->get_where("voters", array("identity_key"=>$voter));
    if ($query->num_rows() > 0) {
      return true;
    }
    return false;
  }
  private function resolveVoter($idKey) {
    return $this->db->get_where("voters", array("identity_key" => $idKey))->result()[0]->id;
  }
}
?>
