<?php

if (isset($tutoriel['title'])) {
	$title = $tutoriel['title'];
	$title_for_layout = $tutoriel['title'];
}

$pub = $tutoriel['publication'];
$modif = $tutoriel['modification'];

		?>





<div class="content-section-b" id="content">

    <div class="row">

      <div class="col-md-12">
      	<h1><?= $title; ?></h1>
		<?= $tutoriel['content']; ?>

    </div>

	</div>
	<div id="editor"><button id="cmd">generate PDF</button></div>
</div>
		<?php ob_start(); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script>
var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('<?= $tutoriel['title']; ?>.pdf');
});

</script>

		<?php $script = ob_get_clean(); ?>

<!-- /.content-section-a -->