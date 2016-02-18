
<div class="content-section-b">

    <div class="container">
        <div class="row">

          <div class="col-lg-8 col-lg-offset-2">
            <h1>S'inscrire</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>

      <?php endforeach ?>
    </ul>
  </div>

<?php endif ?>

<form action="" method="POST">

  <div class="form-group">
    <label for="username">Pseudo</label>
    <input type="text" name="username" class="form-control" />
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" />
  </div>
    <div class="form-group">
    <label for="password">Mot de passe</label>
    <input type="password" name="password" class="form-control" />
  </div>
    <div class="form-group">
    <label for="password_confirm">Confirmer votre mot de passe</label>
    <input type="password" name="password_confirm" class="form-control" />
  </div>
  <button type="submit" class="btn btn-primary">M'Inscrire</button>

</form>


        </div>

    </div>
    <!-- /.container -->

</div>
<!-- /.content-section-a -->