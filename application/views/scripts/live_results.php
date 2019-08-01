<script type="text/javascript">
setInterval(function() {
  $.get("<?=site_url("SMSVoteAPI/getCurrentResults")?>", function(data, status) {
    var results = JSON.parse(data);
    for(var x = 0; x < results.length; x++) {
      $("#p-" + results[x][0]).css("width", (results[x][1]) + "%");
      $("#l-" + results[x][0]).html((results[x][1]) + "%");
      console.log("refreshed");
    }
  })
}, 10000);
</script>
