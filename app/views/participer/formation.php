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
	<p>Cette page vous permet de nous envoyer des formation complets ou partiels.</p>
	<form method="post">

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
				<label for="title">Sujet* </label>
				<?php  echo BootsForm::input('title'); ?>
				</div>
				
			</div>

			<div class="col-sm-4">
				<div class="form-group">
					<label for="your_name">Votre nom* </label>
					<?php  echo BootsForm::input('your_name'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				
				<div class="form-group">
					<label for="your_email">Courriel* </label>

					<?php  echo BootsForm::input('your_email'); ?>
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
							<option value="<?php echo $k; ?>"><?php echo $v['name']; ?></option>
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
		/* http://www.w3schools.com/jsref/met_win_open.asp */

		/*var newWindow = window.open("", "newWindow", "resizable=yes");
		newWindow.document.write('<p>Pop up window text</p>');*/
		function testwindow(x) {
		  var content;
		  var linkWin = window.open("", "newWindow",'width=300,height=200,resizable=yes,toolbar=no');
		  if (!linkWin.opener) { linkWin.opener = self; }
		    content = "<!DOCTYPE html><html><head>";
		    content += "<title>Example</title>";
		    content += '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">';
		    content += '</head><body bgcolor="#ccc">';
		    content += "<p>Any HTML will work, just make sure to escape \"quotes\",";
		    content += 'or use single-quotes instead.</p>';
		    content += "<p>You can even pass parameters… (" + x + ")</p>";
		    content += "</body></html>";
		    content += '<div class="row"><div class="col-md-6">try</div><div class="col-md-6">bootstrap</div></div>';
		    linkWin.document.open();
		    linkWin.document.write(content);
		    linkWin.document.close();
		    //return false;
		}
		//testwindow("dghdfhdh");








		//var editor = document.getElementById('content'); 
		var displayer = document.getElementById('displayer');

		var content = tinyMCE.get('content');


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

