<?php
class SMSVoteAPI extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model("preferences");
  }
  function flagModuleConnection() {
    $flag = $this->uri->segment(3) == 1 ? "true" : "false";
    if ($this->preferences->setPreference("module_connected", $flag)) {
      echo "1";
    } else {
      echo "0";
    }
  }
  function flagModuleReady() {
    $flag = $this->uri->segment(3) == 1 ? "true" : "false";
    if ($this->preferences->setPreference("module_ready", $flag)) {
      echo "1";
    } else {
      echo "0";
    }
  }
  function vote() {
    $this->load->model("console");
    if ($this->console->checkElectionState()) {
      $voter = $this->uri->segment(3);
      $codes = array();
      $index = 4;
      $buffer = $this->uri->segment($index);
      while ($buffer != "") {
        $codes[] = $buffer;
        ++$index;
        $buffer = $this->uri->segment($index);
      }
      $this->load->model("BallotBox");
      echo json_encode($this->BallotBox->vote($voter, $codes));
    } else {
      echo json_encode(array("fraud"=>-1, "errors"=>-1));
    }
  }
  function getCurrentResults() {
    $this->load->model("candidates");
    $this->load->model("ballotbox");
    $this->load->model("categories");
    $categories = $this->categories->getCategories();
    $results = array();
    for ($x = 0; $x < count($categories); $x++) {
      $candidates = $this->candidates->getCandidatesInCategory($categories[$x]["id"]);
      for ($y = 0; $y < count($candidates); $y++) {
        $results[] = array((int) $candidates[$y]["id"], $this->ballotbox->getResultForCandidate($candidates[$y]["id"]));
      }
    }
    echo json_encode($results);
  }
  function getMessages() {
    $this->load->model("sms");
    $this->load->model("ballotbox");
    $messages = $this->sms->getMessages();
    for ($x = 0; $x < count($messages); $x++) {
      if ($this->ballotbox->idHasMap($messages[$x]["_to"])) {
        $phone = $this->db->get_where("voters", array("id"=>$messages[$x]["_to"]))->result_array()[0]["identity_key"];
        if (substr($phone, 0, 4) != "+234") {
          $phone = substr($phone, 1);
          $messages[$x]["_to"] = "+234" . $phone;
        } else {
          $messages[$x]["_to"] = $phone;
        }
      } else {
        $phone =$messages[$x]["_to"];
        if (substr($phone, 0, 4) != "+234") {
          $phone = substr($phone, 1);
          $messages[$x]["_to"] = "+234" . $phone;
        } else {
          $messages[$x]["_to"] = $phone;
        }
      }
    }
    echo json_encode($messages);
  }
  function deleteMessageByDestination() {
    $phone = $this->uri->segment(3);
    $this->load->model("ballotbox");
    if ($this->ballotbox->validateVoter($phone)) {
      $id = $this->db->get_where("voters", array("identity_key"=>$phone))->result_array()[0]["id"];
      $this->load->model("sms");
      if ($this->sms->deleteSMS($id)) {
        echo "1";
      } else {
        echo "0";
      }
    } else {
      $this->load->model("sms");
      if ($this->sms->deleteInvalidSMS($phone)) {
        echo "1";
      } else {
        echo "0";
      }
    }
  }
}
?>
