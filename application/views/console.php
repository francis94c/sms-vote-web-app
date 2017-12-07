<?php
$ci =& get_instance();
$ci->load->view("panel", array("text"=>"Election Processing"));
?>
<a href="<?=site_url("home/toggleElectionStatus")?>"<button class="w3-button <?php echo $status == "On" ? "w3-green" : "w3-gray"?> w3-center"><?=$status?></button></a>
<?php
$ci->load->view("panel", array("text"=>"Actions"));
?>
<button onclick="promptCleanBallotBox();" class="w3-button w3-gray w3-center">Clear Election Records</button>
