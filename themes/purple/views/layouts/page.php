<!-- page -->
<div class="<?= $wrapper_class ?> page-wrapper">
  <img src="/themes/purple/assets/images/about-bg.svg" alt="" class="wave-bottom-top">
  <img src="/themes/purple/assets/images/flower-catalog.png" alt="" class="petal-bottom-top">
  <img src="/themes/purple/assets/images/flower-two.png" alt="" class="flower-bottom-top">
  <img src="/themes/purple/assets/images/contacts-bg.svg" alt="" class="contacts-bottom-top">
  <img src="/themes/purple/assets/images/faq.svg" alt="" class="faq-bottom-top">
  <div class="wrapper-service-catalog">
    <div class="breadcrumbs">
      <div class="breadcrumb-item">
        <?php foreach ($breadcrumbs as $breadcrumb) {
          if (isset($breadcrumb['active']) and $breadcrumb['active'] === true) {
            echo '<li class="breadcrumb-item active">' . $breadcrumb['title'] . '</li>';
            if (isset($breadcrumb['arrow'])) {
              echo '<i class="fa-solid fa-chevron-right"></i>';
            }
          } else {
            echo '<li class="breadcrumb-item primary-text"><a href="' . $breadcrumb['link'] . '">' . $breadcrumb['title'] . '</a></li>';
            echo '<i class="fa-solid fa-chevron-right"></i>';
          }
        } ?>
      </div>
      <a href="<?= $back_button_url ?>" class="back-button">
        <img src="/themes/purple/assets/images/back.png"><?= t('back') ?>
      </a>
    </div>
    <?php if ($display_title === true) { ?>
      <div class="contacts-header">
        <div class="contacts-title path-catalog">
          <h2><?= $page_title ?></h2>
        </div>
        <?php if (!empty($title_breadcrumbs)) { ?>
          <div class="title-breadcrumbs  path-catalog-two">
            <?php foreach ($title_breadcrumbs as $title_breadcrumb_item) { ?>
              <div class="title-breadcrumb-item"><?= mb_strtoupper($title_breadcrumb_item) ?></div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
    <?= $content ?>
  </div>
</div>
<?php if (isset($additional_content) and $additional_content !== false) {
  echo $additional_content;
} ?>
<div class="footer-line">
  <img src="/themes/purple/assets/images/flower-footer.png" alt="цветок">
</div>
<!-- page -->