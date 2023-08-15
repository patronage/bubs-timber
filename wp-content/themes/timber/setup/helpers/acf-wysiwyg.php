<?php

/*
 * -----------------------------------------------------------------------------
 * Advanced Custom Fields Modifications
 * https://gist.github.com/courtneymyers/eb51f918181746181871f7ae516b428b
 * -----------------------------------------------------------------------------
 */
function bubs_apply_acf_modifications() {
    ?>
<style>
.acf-editor-wrap iframe {
    min-height: 0;
}
</style>
<script>
(function($) {
    // (filter called before the tinyMCE instance is created)
    acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
        // enable autoresizing of the WYSIWYG editor
        mceInit.wp_autoresize_on = true;
        return mceInit;
    });
    // (action called when a WYSIWYG tinymce element has been initialized)
    acf.add_action('wysiwyg_tinymce_init', function(ed, id, mceInit, $field) {
        // reduce tinymce's min-height settings
        ed.settings.autoresize_min_height = 100;
        ed.settings.autoresize_max_height = 400;
        // reduce iframe's 'height' style to match tinymce settings
        $('.acf-editor-wrap iframe').css('height', '100px');
    });
})(jQuery)
</script>
<?php
}

/*
 * -----------------------------------------------------------------------------
 * WordPress hooks
 * -----------------------------------------------------------------------------
 */
add_action('acf/input/admin_footer', 'bubs_apply_acf_modifications');
