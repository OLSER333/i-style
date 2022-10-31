
  <?=$header?>
  <?=$sidebar?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?=$title?></h1>
      <nav>
        <ol class="breadcrumb">
          <?php if(!isset($breadcrumbs) or empty($breadcrumbs)) { ?>
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="/admin">Админ</a></li>
          <li class="breadcrumb-item active"><?=$title?></li>
          <?php } else {
            foreach($breadcrumbs as $breadcrumb) {
              if(isset($breadcrumb['active']) and $breadcrumb['active'] === true) {
                echo '<li class="breadcrumb-item active">'.$breadcrumb['title'].'</li>';
              } else {
                echo '<li class="breadcrumb-item"><a href="'.$breadcrumb['link'].'">'.$breadcrumb['title'].'</a></li>';
              }
            }
          } ?>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <?=$content?>
        <div style='height: 80px;'></div>
    </section>

  </main><!-- End #main -->

  <?=$footer?>
