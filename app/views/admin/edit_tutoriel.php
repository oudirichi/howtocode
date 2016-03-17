<?php 

use lib\ViewHelper\BootsForm;
use lib\ViewHelper\HtmlHelper;

 ?>
 <style>
	#displayer{
    	height: 540px;
    	overflow: auto;
	}
 </style>
    <br><br>
	<form method="post" action="<?= (isset($tutoriel))? lib\App::$_WEBROOT_LINK. "admin/tutoriel/" . $tutoriel['id'] : lib\App::$_WEBROOT_LINK. "admin/tutoriel"; ?>">

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
				<label for="title">Sujet* </label>
				<?php  echo BootsForm::input('title'); ?>
				</div>
				
			</div>

			<div class="col-sm-4">
				<div class="form-group">
				<label for="title">Slug* </label>
				<?php  echo BootsForm::input('slug'); ?>
				</div>
				
			</div>
	
			<div class="col-sm-4">
				<div class="form-group">
					<label for="classification">État</label>
					<select class='form-control' id='online' name='online'>
							<option value="0" <?= $tutoriel['online'] == 0 ? " selected" : "" ?>>Brouillon</option>
							<option value="1" <?= $tutoriel['online'] == 1 ? "selected" : "" ?>>Publié</option>
					</select>
				</div>
				
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12">

				<div class="form-group">
					<label for="classification">Classification du guide </label>
					<select class='form-control' id='classification' name='classification'>
						<option value="0">Selectionner une catégorie</option>
						<?php foreach ($arr_categories as $k => $v): ?>
						
							<?php if (isset($tutoriel)): ?>
								<option value="<?= $v['id']; ?>" <?= $tutoriel['id_category'] == $v['id'] ? "selected" : "" ?>><?= $v['name']; ?></option>
							<?php else: ?>
								<option value="<?= $v['id']; ?>"><?= $v['name']; ?></option>
							<?php endif ?>
						<?php endforeach ?>		
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="content">Contenu du guide*</label>
					<?php echo BootsForm::textarea('content'); ?>
				</div>
				<br>
			</div>
			<div class="col-sm-6">
				<label>Prévisualisation</label>
				<div id="displayer"></div>
			</div>

		</div>
		<div class="row">

			<div class="col-sm-12">
				<p>*Les champs marqués d'un astérisque sont obligatoires.</p>
				<button type="submit" class="btn btn-success">Enregistrer</button>
			</div>
		</div>
	</form>
	<br>
	
	<?php 



	/*	
	*ob_start() et ob_get_clean permet de stocker tout le contenue entre les deux dans une variable.
	*/
	/*
	* Inclusion de tinyMCE pour permettre d'écrire normalement sans html
	*/
	?>
		<?php ob_start(); ?>
				<?= HtmlHelper::script(['tinymce/tinymce.min']); ?>

<script>
tinymce.init({
    selector: "textarea#content",
    theme: "modern",
   /* width: 300,*/
    height: 400,
   plugins: [
         "advlist autolink link lists charmap print preview hr",
         "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality paste"
   ],
  /* toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  link unlink image   media  fullpage | preview", */
      toolbar: "styleselect | bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright alignjustify | link unlink", 


 }); 
</script>
<script>
	window.addEventListener("load", function(){

		//var editor = document.getElementById('content'); 
		var displayer = document.getElementById('displayer');

		var content = tinyMCE.get('content');
		displayer.innerHTML = tinymce.activeEditor.getContent();

		/*editor.addEventListener("input", function(){
			//displayer.innerHTML = editor.getContent();
			displayer.innerHTML = editor.value;
        });*/

        content.on('input', function(e) {
		    displayer.innerHTML = tinymce.activeEditor.getContent();
		});
		

	});
</script>

		<?php $script = ob_get_clean(); ?>

