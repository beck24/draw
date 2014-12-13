
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    require('wPaint.text');

    var init = function() {

        $('#wPaint').wPaint({
            path: elgg.get_site_url() + 'mod/draw/vendors/wPaint/',
            bg: '#cccccc'
        });
        
        $('form').submit(function() {
            $('#draw-image-result').val($("#wPaint").wPaint("image"));
           return true;
        });

    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});