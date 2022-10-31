<!-- landing -->
<?= $header ?>
<img class='header-left-image flower-two' src='/themes/purple/assets/images/flower-two.png'>
<img class='header-left-image inc' src='/themes/purple/assets/images/flower-landing-top.png'>

<main class="main">
    <img class="landing-ink-img" src="/themes/purple/assets/images/ink.png" alt="">
    <img class="landing-razor-img" src="/themes/purple/assets/images/razor.png" alt="">
    <img class='landing-flower-img-right' src='/themes/purple/assets/images/flower-two.png'>
    <img class='landing-flower-img-right-two' src='/themes/purple/assets/images/flower-three.png'>
    <section class="landing-service-search">
        <img class='landing-search-vector' src="/themes/purple/assets/images/vector1.png" alt="">
        <div class=' landing-service-search__header'>
            <h1><?= t('landing_title') ?></h1>
            <h3><?= t('landing_subtitle', false, '<span class="primary-text bold">' . $offers_count . '+</span>') ?></h3>
            <p><?= t('landing_text') ?></p>
        </div>
        <div class='landing-service-search__panel'>
            <form class='landing-service-search__form'>
                <div class="landing-service-search__form-container">
                    <div class="landing-service-search__filter">
                        <select name="" class="select-input big-input smile">
                            <option value=""><?= t('choose_service') ?></option>
                            <option value="">Выбрать услугу</option>
                            <option value="">Выбрать услугу</option>
                            <option value="">Выбрать услугу</option>
                        </select>

                        <select name="" class="select-input big-input location">
                            <option value=""><?= t('city') ?></option>
                            <option value="">Город</option>
                            <option value="">Город</option>
                            <option value="">Город</option>
                        </select>

                        <button class="button big-button primary-button"><?= t('show_services') ?></button>
                    </div>
                    <div class="landing-service-search__filter-type">
                        <label class="checkbox-block">
                            <input type="checkbox" name="" id="">
                            <?= t('master') ?>
                        </label>
                        <label class="checkbox-block">
                            <input type="checkbox" name="" id="">
                            <?= t('salon') ?>
                        </label>
                    </div>
                    <div class="landing-service-search__popular-queries popular-queries">
                        <p class="popular-queries__text"><?= t('popular_queries') ?>:</p>
                        <div class="popular-queries__list">
                            <a href="" class="button second-button small-padding">Мужская стрижка</a>
                            <a href="" class="button second-button small-padding">Женская стрижка</a>
                        </div>
                    </div>
                </div>
            </form>
            <img class="from-search-flower" src="/themes/purple/assets/images/flower-footer.png" alt="цветок">
        </div>

        <div class='landing-service-search__categories'>
            <img class='landing-catalog-flower' src="/themes/purple/assets/images/flower-catalog.png" alt="">

            <?php

            use function App\getUserAvatar;

            if (!empty($categories_menu)) {
                foreach ($categories_menu as $menuItem) { ?>
                    <a href='/<?= $menuItem['service_category_slug'] ?>' class='category-item'>
                        <img class='category-img' src='<?= $menuItem['service_category_image'] ?>'>
                        <span class="category-title"><?= strtoupper(t($menuItem['lang_key'], $menuItem['service_category_name'])) ?></span>
                    </a>
            <?php }
            } ?>
            <?php if (!empty($additional_categories_menu)) { ?>

                <?php foreach ($additional_categories_menu as $menuItem) { ?>
                    <a href='/<?= $menuItem['service_category_slug'] ?>' class='category-item additional-item hidden-item'>
                        <img class='category-img' src='<?= $menuItem['service_category_image'] ?>'>
                        <span class="category-title"><?= strtoupper(t($menuItem['lang_key'], $menuItem['service_category_name'])) ?></span>
                    </a>
                <?php } ?>
                <a href='#' class='category-item' data-open='0' id='more_categories_toogle'>
                    <img class='category-img more-toogle' src='/themes/purple/assets/images/piling.png'>
                    <div class='more-categories'>
                        <span id='more_categories_text' open-text='<?= t('more_categories') ?>' close-text='<?= t('fewer_categories') ?>' class=""><?= t('more_categories') ?></span>
                        <span id='rotate_toogle'>
                            <img class="arrow-more" src='/themes/purple/assets/images/arrow-white.png'>
                        </span>
                    </div>
                </a>
            <?php } ?>
        </div>
    </section>

    <section class="landing-best-salons-masters">
        <img class='landing-salons-vector' src="/themes/purple/assets/images/salon-vector.svg" alt="">
        <img class='landing-salons-flower' src="/themes/purple/assets/images/flower-salons.png" alt="">

        <div class="landing-best-salons-masters__container">
            <div class="landing-best-salons__titile landing-block__title">
                <h2 class="landing-best-salons__logo landing-block__logo"><?= t('best_salons') ?></h2>
                <p class="landing-best-salons__subtitle landing-block__subtitle"><?= t('best_salons_text') ?></p>
            </div>

            <?php if (!empty($best_salons)) { ?>
                <div class="landing-best-salons__list">
                    <?php foreach ($best_salons as $salon) {
                        echo $salon;
                    } ?>
                </div>
            <?php } else {
                echo '<p class="no-results">' . t('no_results') . '</p><div class="landing-best-salons__list"></div>';
            } ?>

            <div class="landing-best-masters__titile landing-block__title">
                <h2 class="landing-best-masters__logo landing-block__logo"><?= t('best_masters') ?></h2>
                <p class="landing-best-masters__subtitle landing-block__subtitle"><?= t('best_masters_text') ?></p>
            </div>

            <?php if (!empty($best_masters)) { ?>
                <div class="landing-best-master__list">
                    <img class='landing-salons-flower-two' src="/themes/purple/assets/images/flower-footer.png" alt="">
                    <?php foreach ($best_masters as $master) {
                        echo $master;
                    } ?>
                </div>
            <?php } else {
                echo '<p class="no-results">' . t('no_results') . '</p><div class="landing-best-master__list"></div>';
            } ?>
        </div>
    </section>

    <section class="landing-best-works landing-block">
        <img class='landing-slider-vector' src="/themes/purple/assets/images/slider-vector.svg" alt="">

        <div class="landing-best-works__container landing-block__wrapper">
            <div class="landing-best-works__title landing-block__title">
                <h2 class="landing-best-works__logo landing-block__logo"><?= t('month_works') ?></h2>
                <p class="landing-best-works__subtitle  landing-block__subtitle"><?= t('month_works_text') ?></p>
            </div>

            <div class="landing-best-works__slider landing-block__container works-slider">
                <?php if (!empty($best_works) and count($best_works) > 4) { ?>
                    <div class="works-slider-button works-slider-button__left works-button slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></div>
                    <p class="number-group-slides">Показано <span class="current-slide"></span> из <span class="all-slides"></span></p>
                    <div class="works-slider-button works-slider-button__right works-button slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></div>
                <?php } ?>

                <div data-gap='20' data-count='4' class="landing-best-works__slider-container slide-images">
                    <?php if (!empty($best_works)) {
                        foreach ($best_works as $key => $work) { ?>
                            <div data-slide="<?= $key + 1 ?>" class="landing-best-works__slider-card landing-best-work-card slide-item">
                                <div class="landing-best-work-card__star"><img src="/themes/purple/assets/images/best-icon.png"></div>

                                <?php if (!empty($work['photo_path'])) {  ?>
                                    <div class="landing-best-work-card__photo slide-images-block-white-bg">
                                        <img src="<?= $work['photo_path'] ?>" alt="">
                                    </div>
                                <?php } else { ?>
                                    <div class="landing-best-work-card__photo slide-images-block">
                                        <img src="/assets/img/no_image2.png" alt="">
                                    </div>
                                <?php } ?>
                                <div class="landing-best-work-card__info work-card-info">
                                    <div class="work-card-info__container">
                                        <div class="work-card-info__logo">
                                            <?= getUserAvatar(strval($work['user_avatar']), $work['name']) ?>
                                        </div>
                                        <div class="work-card-info__desc">
                                            <a href="/<?= $work['service_slug'] ?>" class="work-card-info__service-slug button second-button small-padding">
                                                <span class="work-card-info__service-name text-1-row"><?= t($work['lang_key'], $work['service_name']) ?></span>
                                            </a>
                                            <div class='work-card-info__text text-1-row raleway font12'><span class="normal gray-text"><?= t($work['user_role']) ?>:</span> <a class='work-card-info__user hover' href="/sellers/<?= $work['user_id'] ?>"><?= $work['name'] ?></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } else {
                        echo '<p class="no-results">' . t('no_results') . '</p><div class=landing-best-works__slider-card"></div>';
                    } ?>
                </div>

            </div>
        </div>
    </section>

    <section class="landing-offer landing-block">
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
</main>
<?= $footer ?>
<!-- landing -->