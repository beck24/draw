
<div class="draw-sidebar">
  <b><?php echo elgg_echo('draw:color'); ?>:</b><span id="colorSelector-sample"></span><br><br>
  <div id="colorSelector"></div>

  <br><br>
  
 	<b><?php echo elgg_echo('draw:width'); ?>:</b><span id="lineWidth-sample">1</span><br><br>
  <div id="draw-slider"></div>
  
  <br><br>
  
  <?php echo elgg_view('input/button', array('id' => 'draw-reset', 'value' => elgg_echo('draw:reset'))); ?>
</div>
