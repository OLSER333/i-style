<section class="landing-offer landing-block">
    <img src="/themes/purple/assets/images/wave-bottom.svg" class="wawe-bottom" alt="">
    <img class="landing-offer-flower-two" src="/themes/purple/assets/images/offer-flower.png" alt="">
    <div class="landing-offer__container landing-block__wrapper">
        <img class="landing-offer-flower" src="/themes/purple/assets/images/offer-flower.png" alt="">

        <div class="landing-offer__info">
            <h2 class="landing-offer__title"><?= t('partner_title') ?></h2>
            <p class="landing-offer__text"><?= t('partner_text') ?></p>
            <a href="/business" class="landing-offer__button button primary-button big-button"><?= t('be_partner') ?></a>
        </div>

        <div class='landing-offer__img'>
            <img src="/themes/purple/assets/images/offer-image.png" alt="">
        </div>

        <img class="offer-small-flower" src="/themes/purple/assets/images/offer-small-flower.png" alt="">
    </div>

    <img class="landing-faq-vector" src="/themes/purple/assets/images/offer-vector.svg" alt="">
</section>

<section class="landing-faq landing-block">
    <div class="landing-faq__container landing-block__wrapper">
        <img class="faq-jar" src="/themes/purple/assets/images/jar.png" alt="">
        <img class="faq-flower" src="/themes/purple/assets/images/flower-two.png" alt="">
        <div class="landing-faq__title landing-block__title">
            <h2 class="landing-faq__logo landing-block__logo"><?= t('answers_to_popular_questions') ?></h2>
        </div>
        <div class="landing-faq__content">
            <?php if (!empty($faq)) {
                foreach ($faq as $faqModel) {
                    echo $faqModel;
                }
            } else {
                echo '<div style="padding: 40px 0px; text-align: center;"><h3>No questions</h3></div>';
            } ?>
        </div>
        <a href="/faq" class="landing-faq__button      button primary-button big-button m-auto"><?= t('more_questions') ?></a>
    </div>
</section>