<p>Il y a présentement <?=$nb_online; ?> guides sur <?=$nb_total;?> de publiés.</p>

	<div> <label for="hide-not-online">Afficher seulement ceux qui sont publiés</label>
	<input type="checkbox" id="hide-not-online" /></div>

	<input type="text" id="search" placeholder="Recherche">
	<table id="table" class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Nom</th>
			</tr>
		</thead>
		<tbody>
	 		<?php foreach ($tutoriel as $v): ?>
					
				<?php if ($v['online']==1): ?>
					<tr><td><?= link_to($v['title'], "formation/$action/{$v['slug']}"); ?>
					</td></tr>
				<?php else: ?>
					<tr class="not-online"><td><?php echo $v['title']; ?></td></tr>
					<?php endif ?>
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


	