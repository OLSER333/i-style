<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="/" class="logo d-flex align-items-center hover-opacity w-auto">
                    <!-- <img src="/assets/img/logo.png" alt=""> -->
                    <span class="d-lg-block"><?=$site_name?></span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Создание аккаунта</h5>
                    <p class="text-center small">Введите ваши персональные данные для завершения регистрации</p>
                  </div>

                  <form method="post" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" value='<?=$user_email?>' name="user_email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Введите корректный адрес почты.</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Пароль</label>
                      <input type="password" value='<?=$user_pass?>' name="user_pass" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Введите ваш пароль!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input <?=$agree_checked?> class="form-check-input" type="checkbox" name="agree" value="true" id="acceptTerms" required>
                        <label class="form-check-label" for="rememberMe">Я согласен с  <a href="/terms">правилами и условиями</a></label>
                        <div class="invalid-feedback">Вы должны согласиться с условиями.</div>
                      </div>
                    </div>
                    
                    <div class="col-12">
                      <p class='text-red'><?=$error?></p>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Зарегистрироваться</button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">Есть аккаунт? <a href="/login">Войдите в систему</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
</main><!-- End #main -->