<?php
class Categories extends CI_Model {
  /**
   * [addCategory description]
   * @param [type] $category [description]
   */
  function addCategory($category) {
    return $this->db->insert("categories", array("name"=>$category));
  }
  /**
   * [getCategories description]
   * @return [type] [description]
   */
  function getCategories() {
    $this->db->order_by("name", "ASC");
    return $this->db->get("categories")->result_array();
  }
  function getCategoryName($id) {
    $query = $this->db->get_where("categories", array("id"=>$id));
    if ($query->num_rows() > 0) {
      return $query->result()[0]->name;
    } else {
      return "Error";
    }
  }
}
?>
