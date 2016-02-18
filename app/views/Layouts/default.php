<?php  use lib\ViewHelper\HtmlHelper; ?>
<?php  HtmlHelper::setDefault(); ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title_for_layout; ?></title>
	

	<?= HtmlHelper::css(['bootstrap','tata']); ?>
	<?= HtmlHelper::script(['bootstrap','tata']); ?>

</head>
<body>
	<div>header</div>
	<hr>
	<?php if (lib\Session::getInstance()->hasFlashes()): ?>
		<?php foreach (lib\Session::getInstance()->getFlashes() as $type => $message): ?>
		  <div class="alert alert-<?php echo $type; ?>">
		    <?php echo $message; ?>
		  </div>
		<?php endforeach ?>
	<?php endif ?>

	<?php echo $content_for_layout; ?>
	<hr>
	<div>footer</div>
</body>
</html>
