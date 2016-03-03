
<style>
    
    /*Block with circle */
.box {
    background-color: #FFF;
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    text-align: right;
    display: block;
    margin-top: 60px;
}
.box-icon {
    background-color: #03a9f4;/* #57a544;*/
    border-radius: 50%;
    display: table;
    height: 100px;
    margin: 0 auto;
    width: 100px;
    margin-top: -61px;

    border: solid 4px #0288d1;
    border-top-color: transparent;
    border-left: transparent;
    border-right: transparent;
}
.box-icon span {
    color: #fff;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.info h4 {
    /*font-size: 26px;*/
    letter-spacing: 2px;
    text-transform: uppercase;
    margin: 10px;
    font-weight: bold;
    font-size: 1.2rem;
    line-height: 1.4;
}
.info > p {
    color: #717171;
    font-size: 16px;
    padding-top: 10px;
    text-align: justify;
}
.info a {
    background-color: #03a9f4;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
.info a:hover {
    background-color: #0288d1;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}

.float-right{
	float:right;
}
/*Fin*/

</style>

	<br>

	<input type="text" id="search" placeholder="Recherche">
	<table id="table" class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Nom</th>
			</tr>
		</thead>
		<tbody>
	 		<?php foreach ($tutoriel as $v): ?>
					
					<tr><td><?= link_to($v->title, "tutoriel/$action/{$v->slug}"); ?>
					</td></tr>

			<?php endforeach ?>
		</tbody>
	</table>

	<?php if (isset($tutoriel)): ?>
<div class="row">
<?php foreach ($tutoriel as $v): ?>


    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="box">
            <div class="box-icon">
                <span class="<?= $v->icon; ?>"></span>
            </div>
            <div class="info">
                <h4 class="text-center"><?= $v->title; ?></h4>

                <?= link_to("Liens", "tutoriel/{$v->link}/{$v->slug}", ['class' => ["btn"]]); ?>
            </div>
        </div>
    </div>

<?php endforeach ?>
</div>
<?php endif ?>





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


	