<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/user">Registrar Nuevo</a></li> 
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Inicio de Sesion</h5>
            <form class="form-signin" action="<?=route_to('user_login_post')?>" method="POST" enctype="multipart/form-data">
              <div class="form-floating mb-3">
                <input id="email" name="email" type="text" class="form-control" placeholder="name@example.com">
                <label for="email">Correo o Usuario</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="empleadoCheck" name="empleadoCheck">
                <label class="form-check-label" for="empleadoCheck">
                  Administrador
                </label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Iniciar Sesion</button>
              </div>
              <hr class="my-4">           
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>