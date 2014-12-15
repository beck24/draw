<?php

namespace Draw;

echo elgg_view_form('draw/avatar', array(), $vars);
?>

<script>
	$(document).ready(function() {
		$('#wPaint').wPaint({
            path: elgg.get_site_url() + '/mod/draw/vendors/wPaint/',
            bg: '#ffffff'
        });
        
        $('form.elgg-form-draw-avatar').submit(function() {
            $('#draw-image-result').val($("#wPaint").wPaint("image"));
           return true;
        });

		$('.wPaint-menu.wPaint-menu-alignment-horizontal').css('width', '260px');
	});
</script>