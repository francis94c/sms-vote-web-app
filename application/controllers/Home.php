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
    $this->load->view("manage_categories");
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
    $this->load->view("manage_categories");
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

}
?>
