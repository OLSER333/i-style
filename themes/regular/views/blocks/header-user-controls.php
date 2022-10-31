
<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

    

    <li class="nav-item dropdown pe-3" style='padding-right: 20px;'>

        <a class="nav-link nav-profile d-flex align-items-center pe-0 hover-opacity" href="#" data-bs-toggle="dropdown">
            <?=$avatar?>
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=$short_name?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
                <h6><?=$full_name?></h6>
                <span><?=$email?></span>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Личный кабинет</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center" href="/profile/settings">
                <i class="bi bi-gear"></i>
                <span>Настройки профиля</span>
                </a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center" href="/profile/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Выход</span>
                </a>
            </li>

        </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

    </ul>
</nav><!-- End Icons Navigation -->