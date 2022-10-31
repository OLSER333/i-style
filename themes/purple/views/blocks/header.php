<!-- HEADER -->
<nav class="header-nav">
    <img class='header-left-image flower' src='/themes/purple/assets/images/flower.png'>
    <div class="border-bottom">
        <div class="wrapper-header">
            <div class='header-information'>
                <a href='/' class="main-logo">
                    <img src="/themes/purple/assets/images/logo.png">
                </a>
                <div class="salons-count header-information-element"><?= $salons_with_us ?></div>
                <a href="/business" class="button gray-button header-information-element"><?= t('for_business') ?></a>
                <div class="burger-menu-container header-information-element">
                    <a href="#" class="burger-menu dropbox-toogle" data-click='0' data-hidden='hidden-dropbox-menu' data-rotate=".lang-icon" data-content='#header_dropbox'>
                        <img class="lang-icon" src='/themes/purple/assets/images/burger.svg'>
                    </a>
                    <div id='header_dropbox' class="header-dropbox-menu hidden-dropbox-menu">
                        <a href="#" class="close-header-dropbox" data-content='#header_dropbox' data-hidden='hidden-dropbox-menu'>
                            <img src="/themes/purple/assets/images/close.svg" alt="">
                        </a>
                        <a href='/faq'><?= t('faq') ?></a>
                        <a href='/contacts'><?= t('contacts') ?></a>
                        <a href='/about'><?= t('about_us') ?></a>
                        <a href='/catalog'><?= t('service_catalog') ?></a>
                    </div>
                </div>

                <div class='header-search header-information-element'>
                    <button class='header-search-button dropbox-toogle' data-click='0' data-rotate='.arrow-icon' data-hidden='hidden-dropbox-search' data-content='#search_up'><img src='/themes/purple/assets/images/search.svg'></button>
                    <form id='search_up' class='header-search-form hidden-dropbox-search'>
                        <input type="text" placeholder="<?= t('find_service') ?>" class="text-input">
                        <button class='search-button'><img src='/themes/purple/assets/images/search.svg'></button>
                        <button class="close-search-dropbox" data-content='#search_up' data-hidden='hidden-dropbox-search'><img src="/themes/purple/assets/images/close.svg" alt=""></button>
                    </form>
                </div>
                <div class='nunito header-language-select'>
                    <div data-click='0' data-rotate='.arrow-icon' data-hidden='lang-list-hidden' data-content='#lang_menu' class='language-select dropbox-toogle'>
                        <img class="lang-icon" src='/themes/purple/assets/images/lang.svg'>
                        <span class='current-lang'><?= $current_lang ?></span>
                        <img class="arrow-icon" src='/themes/purple/assets/images/arrow-down.svg'>
                    </div>
                    <div id='lang_menu' class="lang-list lang-list-hidden">
                        <img class="lang-icon" src='/themes/purple/assets/images/lang.svg'>
                        <div class="lang_column">
                            <?php if (!empty($lang_menu)) {
                                foreach ($lang_menu as $langItem) { ?>
                                    <a href='<?= $langItem['lang_link'] ?>' class='block <?= $langItem['active_class'] ?>'><?= $langItem['lang_code'] ?></a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <?php if (isset($display_auth_menu) and $display_auth_menu === true) { ?>
                    <!-- РЕФАКТОР -->
                    <div class="user-auth-menu header-information-element">
                        <div class="button primary-button flex-button button-p10 gap-10 dropbox-toogle" data-click='0' data-rotate='.arrow-icon' data-hidden='auth-menu-hidden' data-content='#auth_menu'>
                            <div class="user-auth-menu__avatar">
                                <div class="header-user-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class='text-1-row'><?= $header_user_name ?></span>
                            </div>
                            <div class="user-auth-menu__arrow">
                                <div class="header-user-arrow arrow-icon">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                        <div id='auth_menu' class="auth-menu-list auth-menu-hidden">
                            <?php if ($user_role === 'admin') { ?>
                                <a href='/admin' class='block'><?= t('admin_panel') ?></a>
                                <a href='/profile/settings' class='block'><?= t('profile_settings') ?></a>
                                <a href='/profile/logout' class='block'><?= t('logout_from_account') ?></a>
                            <?php } else if ($user_role === 'customer') { ?>
                                <a href='/dashboard' class='block'><?= t('my_service_records') ?></a>
                                <a href='/profile/favorites' class='block'><?= t('favorites') ?></a>
                                <a href='/profile/reviews' class='block'><?= t('my_reviews') ?></a>
                                <a href='/profile/settings' class='block'><?= t('personal_data') ?></a>
                                <a href='/profile/logout' class='block'><?= t('logout_from_account') ?></a>
                            <?php } else if ($user_role === 'master') { ?>
                                <a href='/dashboard' class='block'><?= t('dashboard') ?></a>
                                <a href='/profile/settings' class='block'><?= t('personal_data') ?></a>
                                <a href='/profile/logout' class='block'><?= t('logout_from_account') ?></a>
                            <?php } else if ($user_role === 'salon') { ?>
                                <a href='/dashboard' class='block'><?= t('dashboard') ?></a>
                                <a href='/profile/settings' class='block'><?= t('personal_data') ?></a>
                                <a href='/profile/logout' class='block'><?= t('logout_from_account') ?></a>
                            <?php } else if ($user_role === 'salon_master') { ?>
                                <a href='/dashboard' class='block'><?= t('dashboard') ?></a>
                                <a href='/profile/settings' class='block'><?= t('personal_data') ?></a>
                                <a href='/profile/logout' class='block'><?= t('logout_from_account') ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- РЕФАКТОР -->
                <?php } else { ?>
                    <div id='dropbox-auth-buttons' class="auth-buttons dropbox-auth-buttons hidden-dropbox-menu">
                        <a href="/sign_in" class="button second-button-primary-text"><?= t('login') ?></a>
                        <a href="/sign_up" class="button primary-button"><?= t('registration') ?></a>
                        <a href="#" class="close-header-dropbox" data-content='#dropbox-auth-buttons' data-hidden='hidden-dropbox-menu'>
                            <img src="/themes/purple/assets/images/close.svg" alt="">
                        </a>
                    </div>
                    <a href="#" class="dropbox-toogle auth-image" data-click='0' data-hidden='hidden-dropbox-menu' data-content='#dropbox-auth-buttons'>
                        <img src="/themes/purple/assets/images/auth-icon-default.svg" class="auth-icon header-information-element">
                    </a>

                <?php } ?>
            </div>
            <div class='header-menu'>
                <?php if (!empty($main_menu)) {
                    foreach ($main_menu as $menuItem) { ?>
                        <a class='<?= $menuItem->active ?>' href='<?= $menuItem->url ?>'><?= $menuItem->title ?></a>
                    <?php } ?>
                    <a class='bold' href='/discounts'><?= t('discounts', 'Скидки и акции') ?></a>
                    <?php if (!empty($additional_menu)) { ?>
                        <a class='dropbox-toogle all-service-button' data-click='0' data-rotate='.arrow-icon' data-hidden='hidden-menu' data-content='#dropbox_menu' href='#'><?= t('all_services', 'Все услуги') ?> <img class="arrow-icon ml10" src='/themes/purple/assets/images/arrow-down.svg'></a>
                <?php }
                } ?>
            </div>
        </div>
    </div>

    <div id='dropbox_menu' class="hidden-menu additional-menu-box">
        <div class='additional-menu'>
            <?php if (!empty($additional_menu)) {
                foreach ($additional_menu as $menuItem) { ?>
                    <a class='<?= $menuItem->active ?>' href='<?= $menuItem->url ?>'><?= $menuItem->title ?></a>
            <?php }
            } ?>
        </div>
    </div>
</nav>
<!-- HEADER -->