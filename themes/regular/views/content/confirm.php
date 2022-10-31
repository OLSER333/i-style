<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="/" class="logo d-flex align-items-center hover-opacity w-auto">
                    <img src="/assets/img/logo.png" alt="">
                    <span class="d-lg-block"><?=$site_name?></span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Введите код</h5>
                    <p class="text-center small">Код подтверждения был отправлен на ваш адрес электронной почты: <strong><?=$email?></strong></p>
                  </div>

                  <form method="post" class="row g-3 needs-validation" novalidate>
                    
                    <div class="col-12">
                      <label for="yourCode" class="form-label">Код</label>
                      <input type="text" value='<?=$confirm_code?>' name="confirm_code" class="form-control" id="yourCode" required>
                      <div class="invalid-feedback">Введите код.</div>
                    </div>

                    <div class="col-12">
                      <p class='text-red'><?=$error?></p>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Продолжить</button>
                    </div>

                    <div class="col-12"></div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
</main><!-- End #main -->