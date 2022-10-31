<footer class="main-footer">
    <div class="footer-line">
        <img src="/themes/purple/assets/images/flower-footer.png" alt="цветок">
    </div>

    <div class="footer-content">
        <div class="footer-wrapper">
            <div class="footer-information">
                <div class="footer-col-1">
                    <a href="" class="main-logo inline-block hover"><img src="/themes/purple/assets/images/logo.png" alt=""></a>
                    <div class="footer-links">
                        <a href='/policy'><?= t('policy') ?></a>
                        <a href='/terms'><?= t('terms') ?></a>
                    </div>
                </div>
                <div class="footer-col-2">
                    <div class="footer-links">
                        <div>
                            <a href='/about'><?= t('about_us') ?></a>
                            <a href='/faq'><?= t('faq') ?></a>
                            <a href='/discounts'><?= t('discounts') ?></a>
                            <a href='/contacts'><?= t('contacts') ?></a>
                        </div>

                        <?php if (!empty($categories)) {
                            foreach ($categories as $categoriesBlock) { ?>
                                <div>
                                    <?php if (!empty($categoriesBlock)) {
                                        foreach ($categoriesBlock as $menuItem) { ?>
                                            <a href='<?= $menuItem->url ?>'><?= $menuItem->title ?></a>
                                    <?php }
                                    } ?>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="footer-col-3">
                    <a class='auth-icon hover' href="/sign_in">
                        <img src="/themes/purple/assets/images/auth-icon.png" alt="">
                        <div class="auth-icon-shadow"></div>
                    </a>
                </div>
            </div>
            <div class="copyrights nunito">© <?= $year ?> Istyle. <?= t('all_rights_reserved') ?></div>
        </div>
    </div>
</footer>