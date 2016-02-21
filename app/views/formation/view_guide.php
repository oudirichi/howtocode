<?php

if (isset($tutoriel['title'])) {
	$title = $tutoriel['title'];
	$title_for_layout = $tutoriel['title'];
}

$pub = $tutoriel['publication'];
$modif = $tutoriel['modification'];

		?>





<div class="content-section-b">

    <div class="row">

      <div class="col-md-12">
      	<h1><?= $title; ?></h1>
		<?= $tutoriel['content']; ?>

    </div>

</div>
<!-- /.content-section-a -->