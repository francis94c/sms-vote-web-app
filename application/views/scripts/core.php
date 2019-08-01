<script type="text/javascript">
function promptCleanBallotBox() {
  if (confirm("Are You sure you want to clear election records?") == true) {
    window.location.href = "<?=site_url("home/clearElectionRecords")?>";
  }  
}
</script>
