<div class="content-section-b">

    <div class="container">
        <div class="row">

          <div class="col-lg-8 col-lg-offset-2">
<h1>Bonjour <?php echo $_SESSION['auth']->username; ?></h1>

<form action="" method="POST">
  <div class="form-group">
    <input class="form-control" type="password" name="password" placeholder="Changer mot de passe">
  </div>

  <div class="form-group">
    <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du mot de passe">
  </div>
  <button class="btn btn-primary">Changer mon mot de passe</button>
</form>

        </div>

    </div>
    <!-- /.container -->

</div>
<!-- /.content-section-a -->