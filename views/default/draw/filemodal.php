<?php

namespace Draw;

echo elgg_view('forms/draw/file', $vars);
?>

<script>
	$(document).ready(function() {
		var val = $('#draw-image-result').val();
		if (!val) {
			val = $('input[name="draw-existing"]').val();
		}
		
		$('#wPaint').wPaint({
			path: elgg.get_site_url() + '/mod/draw/vendors/wPaint/',
			image: val,
            bg: '#ffffff'
        });
		
		$('.wPaint-menu.wPaint-menu-alignment-horizontal').css('width', '260px');
        
        $('.draw-image-select').click(function() {
			var img = $("#wPaint").wPaint("image");
            $('#draw-image-result').val(img);
			$('.draw-target').html('<img src="'+img+'">');
			$('input[name="upload"]').val('');
			elgg.ui.lightbox.close();
           return true;
        });

	});
</script>