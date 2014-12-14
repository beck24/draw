
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    require('wPaint.text');

    var init = function() {
        $(document).on('change', 'input[name="upload"]', function(e) {
            // they've selected a file, remove any drawings
            $('.draw-target').html('');
            $('#draw-image-result').val('');
        });
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});