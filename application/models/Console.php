<?php
class Console extends CI_Model {
  /**
   * [__construct description]
   */
  function __construct() {
    parent::__construct();
    $this->load->model("Preferences");
  }
  /**
   * [startElection description]
   * @return [type] [description]
   */
  function startElection() {
    return $this->Preferences->setPreference("in_session", "1");
  }
  /**
   * [checkElectionState description]
   * @return [type] [description]
   */
  function checkElectionState() {
    if ($this->Preferences->getPreference("in_session") == "1") {
      return true;
    }
    return false;
  }
  /**
   * [stopElection description]
   * @return [type] [description]
   */
  function stopElection() {
    return $this->Preferences->setPreference("in_session", "0");
  }
  /**
   * [getLiveResults description]
   * @return [type] [description]
   */
  function getLiveResults() {

  }
}
?>
