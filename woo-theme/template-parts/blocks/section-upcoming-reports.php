<?php
$data = get_field('upcoming_reports_fields');

if (!$data) {
    return;
}

if (isset($data['global_reports']) && $data['global_reports'] == true) {
    $field = get_field('fields_upcoming_reports', 'option');
    $reports = (isset($field['upcoming_reports']) && !empty($field['upcoming_reports'])) ? $field['upcoming_reports'] : '';
    $title = (isset($field['title']) && !empty($field['title'])) ? $field['title'] : '';
    $description = (isset($field['description']) && !empty($field['description'])) ? $field['description'] : '';
} else {
    $reports = (isset($data['upcoming_reports']) && !empty($data['upcoming_reports'])) ? $data['upcoming_reports'] : '';
    $title = (isset($data['title']) && !empty($data['title'])) ? $data['title'] : '';
    $description = (isset($data['description']) && !empty($data['description'])) ? $data['description'] : '';
}

$classes = ['upcoming-reports-section animation'];

$info = array();
$new_date = '';
if (!empty($reports)) :
    foreach($reports as $item) :
        if (isset($item['date']) && !empty($item['date'])) {
            $date  = DateTime::createFromFormat( 'd/m/Y', $item['date'] );
            $new_date = $date->format( 'M j, Y' );
            $desc = (isset($item['description']) && !empty($item['description'])) ? $item['description'] : '';
            $info[] = array('date' => $new_date, 'eventDesc' => esc_attr__($desc, 'woo-theme'));
        }
    endforeach;
endif;

if (!empty($info)): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="upcoming-reports-inner">
                <div class="section-info">
                    <?php if (!empty($title)) : ?>
                        <h2><?php echo $title; ?></h2>
                    <?php endif; ?>
                    <?php echo $description; ?>
                    <ul class="upcoming-reports-holder"></ul>
                </div>
                <div class="reports-calendar">
                    <div id="datepicker" data-event-list='<?php echo json_encode($info); ?>'></div>
                </div>
            </div>
        </div>
    </section>
<?php endif;