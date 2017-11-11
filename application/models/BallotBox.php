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
    //$votedCategories = array();
    $flags = array("fraud"=>0, "errors"=>0);
    $c = count($codes);
    for ($x = 0; $x < $c; $x++) {
      $cid = $this->Candidates->resolveCode($codes[$x]);
	    if ($cid == -1) {
        $flags["errors"] = $flags["errors"] + 1;
		    continue;
	    }
	    if (!$this->castVote($voter, $cid)) {
        log_message("error", "Fraud! Could not cast vote " . $voter . "--" . $cid);
        $flags["fraud"] = $flags["fraud"] + 1;
      } 
    }
    return $flags;
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
}
?>
