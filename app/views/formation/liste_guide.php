﻿<br>

	<input type="text" id="search" placeholder="Recherche">
	<table id="table" class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Nom</th>
			</tr>
		</thead>
		<tbody>
	 		<?php foreach ($tutoriel as $v): ?>
				<tr>
					<td><?= link_to($v->title, "formation/$action/{$v->slug}"); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php ob_start(); ?>
<script>
	var $rows = $('#table tr');
	$('#search').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});
</script>
<?php $script = ob_get_clean(); ?>
