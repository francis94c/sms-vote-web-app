<?php
class Home extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->helper("url");
    $this->load->helper("form");
    if (!$this->isValidated()) {
      redirect('login');
    }
  }

  function index() {
    $this->load->model("candidates");
    $this->load->model("categories");
    $data["title"] = "Manage Candidates";
    $data["menu"] = array(
      array("fa-plus", "Add Candidate", site_url("home/showAddCandidate"))
    );
    $data["message"] = "";
    $data["flag"] = 0;
    $this->load->view("header", $data);
    $this->load->view("ul_open");
    $candidates = $this->candidates->getCandidates();
    $c = count ($candidates);
    $buffer = array();
    for ($x = 0; $x < $c; $x++) {
      $buffer["name"] = $candidates[$x]->first_name . " " . $candidates[$x]->last_name . " " . $candidates[$x]->middle_name;
      $buffer["image_url"] = base_url("images/" . $candidates[$x]->image . ".jpg");
      $buffer["category"] = $this->categories->getCategoryName($candidates[$x]->contesting_for);
      $buffer["id"] = $candidates[$x]->id;
      $buffer["code"] = $candidates[$x]->code;
      $this->load->view("single_candidate", $buffer);
    }
    $this->load->view("ul_close");
  }

  function showAddCandidate() {
    $data["title"] = "Manage Candidates";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 0;
    $data["params"] = array(
      "first_name" => "",
      "middle_name" => "",
      "last_name" => "",
      "category" => "");
    $this->load->view("header", $data);
    $this->load->view("add_candidate", $data);
  }

  function showManageCategories() {
    $data["title"] = "Manage Categories";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 1;
    $data["params"] = array(
      "first_name" => "",
      "middle_name" => "",
      "last_name" => "",
      "category" => "");
    $this->load->view("header", $data);
    $this->load->view("manage_categories", $data);
  }

  function isValidated() {
    return $this->session->userdata('validated');
  }

  function deleteCategory() {
    $id = $this->uri->segment(3);
    $this->db->where(array("id"=>$id));
    $this->db->delete("categories");
    $data["title"] = "Manage Categories";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 1;
    $this->load->view("header", $data);
    $this->load->view("manage_categories");
  }

  function addCategory() {
    $category = $this->security->xss_clean($this->input->post('category'));
    $db_debug = $this->db->db_debug;
    $this->db->db_debug = false;
    if ($this->db->insert("categories", array("name"=>$category))) {
      $data["message"] = "<font color=\"green\">Succesfully Added Category.</font>";
    } else {
      $data["message"] = "<font color=\"red\">Category Already Exists.</font>";
    }
    $this->db->db_debug = $db_debug;
    $data["title"] = "Manage Categories";
    $data["menu"] = array();
    $data["flag"] = 1;
    $this->load->view("header", $data);
    $this->load->view("manage_categories", $data);
  }

  function addCandidate() {
    $firstName = $this->security->xss_clean($this->input->post('first_name'));
    $middleName = $this->security->xss_clean($this->input->post('middle_name'));
    $lastName = $this->security->xss_clean($this->input->post('last_name'));
    $category = $this->security->xss_clean($this->input->post('category'));
    if (strlen($firstName) == 0 || strlen($middleName) == 0 || strlen($lastName) == 0 || $category == 0) {
      $data = array();
      $data["title"] = "Add Candidate";
      $data["menu"] = array();
      $data["flag"] = 1;
      $data["message"] = "<font color=\"green\">Missing Fileds</font>";
      $data["params"] = array(
        "first_name" => $firstName,
        "middle_name" => $middleName,
        "last_name" => $lastName,
        "category" => $category);
      $this->load->view("header", $data);
      $this->load->view("add_candidate", $data);
    } else {
      $this->load->library("ObjectModels");
      $candidate = new Candidate($firstName, $middleName, $lastName, $category);
      $this->load->model("candidates");
      if ($this->candidates->createCandidate($candidate)) {
        $config["upload_path"] = APPPATH . "../images";
        $config["allowed_types"] = "gif|jpg|png";
        $config["file_name"] = $candidate->getImageFileName();
        $this->load->library("upload", $config);
        if (!$this->upload->do_upload("passport")) {
          echo $this->upload->display_errors();
        } else {
          $config['image_library'] = 'gd2';
          $config['source_image'] = APPPATH . "../images/" . $candidate->getImageFileName();
          $config['create_thumb'] = FALSE;
          $config['maintain_ratio'] = TRUE;
          $config['width'] = 150;
          $config['height'] = 150;
          $this->load->library('image_lib', $config);
          $this->image_lib->resize();
          $data = array();
          $data["title"] = "Add Candidate";
          $data["menu"] = array();
          $data["flag"] = 1;
          $data["message"] = "<font color=\"green\">Successfully Added Candidate</font>";
          $data["params"] = array(
            "first_name" => "",
            "middle_name" => "",
            "last_name" => "",
            "category" => $category);
          $this->load->view("header", $data);
          $this->load->view("add_candidate", $data);
        }
      } else {
        show_error("Access Denied", 500);
      }
    }
  }

  function deleteCandidate($id) {
    $this->load->model("candidates");
    unlink(FCPATH . "images/" . $this->candidates->getImageFileName($id));
    $this->db->where(array("id"=>$id));
    $this->db->delete("candidates");
    $this->index();
  }

  function showLiveResults() {
    $data["title"] = "Live Results";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 3;
    $this->load->view("header", $data);
    $this->load->model("candidates");
    $this->load->model("ballotbox");
    $this->load->model("categories");
    $this->load->view("ul_open");
    $categories = $this->categories->getCategories();
    for ($x = 0; $x < count($categories); $x++) {
      $this->load->view("panel", array("text" => $categories[$x]["name"]));
      $candidates = $this->candidates->getCandidatesInCategory($categories[$x]["id"]);
      for ($y = 0; $y < count($candidates); $y++) {
        $data = array();
        $data["image_url"] = base_url("images/" . $candidates[$y]["image"] . ".jpg");
        $data["name"] = $candidates[$y]["first_name"] . " " . $candidates[$y]["last_name"] . " " . $candidates[$y]["middle_name"];
        $data["percent"] = $this->ballotbox->getResultForCandidate($candidates[$y]["id"]);
        $this->load->view("status_item", $data);
      }
    }
    $this->load->view("ul_close");
    $this->load->view("scripts/jquery");
    $this->load->view("scripts/live_results");
  }
  function showConsole() {
    $data["title"] = "Console";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 2;
    $this->load->model("console");
    if ($this->console->checkElectionState()) {
      $data["status"] = "On";
    } else {
      $data["status"] = "Off";
    }
    $this->load->view("header", $data);
    $this->load->view("console",$data);
  }
  function toggleElectionStatus() {
    $this->load->model("console");
    if ($this->console->checkElectionState()) {
      $this->console->stopElection();
    } else {
      $this->console->startElection();
    }
    $this->showConsole();
  }
  function showManageEligibleVoters() {
    $data["title"] = "Manage Eligible Voters";
    $data["menu"] = array();
    $data["message"] = "";
    $data["flag"] = 4;
    $this->load->view("header", $data);
    $this->load->model("voters");
    $data["voters"] = $this->voters->getVoters();
    $this->load->view("manage_eligible_voters",$data);
  }
  function addVoter() {
    $voter = $this->security->xss_clean($this->input->post('voter'));
    $this->load->model("voters");
    $this->voters->addVoter($voter);
    $this->showManageEligibleVoters();
  }
  function deleteVoter() {
    $this->load->model("voters");
    if ($this->voters->deleteVoterById($this->uri->segment(3))) {
      $this->showManageEligibleVoters();
    } else {
      show_error("An unknown error occured", 500);
    }
  }
}
?>
