<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}
$classes = ['line']; ?>
<div class="container"><hr class="<?php echo apply_global_classes($classes, $data); ?>"/></div>