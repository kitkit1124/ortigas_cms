<?php // Adds X-Frame-Options to HTTP header, so that page can only be shown in an iframe of the same site.
header('X-Frame-Options: SAMEORIGIN'); ?>

<?php echo $_styles; ?>

<?php echo $content; ?>

<script>
var ajax_url = '<?php echo current_url() ?>';
var csrf_name = '<?php echo $this->security->get_csrf_token_name() ?>';
</script>

<?php echo $_scripts; ?>

