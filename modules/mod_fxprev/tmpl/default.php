<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
      google.load("books", "0");
      function GBPalertNotFound() {
        alert("Book could not be loaded");
      }
      function GBPinitialize() {
          var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
          viewer.load('ISBN:<?php echo $params->get('ISBN')?>', GBPalertNotFound);
      }
      google.setOnLoadCallback(GBPinitialize);
</script>
<div id="viewerCanvas" style="width: <?php echo $params->get('Width')?>px; height: <?php echo $params->get('Height')?>px"></div>

