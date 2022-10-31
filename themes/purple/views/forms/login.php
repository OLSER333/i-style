<!-- login -->
<form method="post" class="auth-form m-auto">
    <h2 class="h2 logo-tilda"><?=t('login_to_profile')?></h2>
    <div class="space20"></div>
    <?php if(isset($enable_social) and $enable_social === true) { ?>
    <div class="social-auth nunito text-center">
        <p class="social-auth-text gray-text bold font16"><?=t('with_social')?></p>
        <div class="space20"></div>
        <div class="flex flex-center social-auth-items gap-10">
            <a href='?google' class="social-auth-item hover">
                <img src="/themes/purple/assets/images/google-icon.png" alt="">
            </a>
            <a href='?facebook' class="social-auth-item hover">
                <img src="/themes/purple/assets/images/facebook-icon.png" alt="">
            </a>
            <a href='?twitter' class="social-auth-item hover">
                <img src="/themes/purple/assets/images/twitter-icon.png" alt="">
            </a>
        </div>
        <div class="space40"></div>
        <div class="flex gap-50">
            <div class="border-div"></div>
            <span class="social-auth-text gray-text bold font16"><?=t('or')?></span>
            <div class="border-div"></div>
        </div>
    </div>
    <?php } ?>
    <div class="space20"></div>
    <div class="flex gap-10">
        <input value="<?=$user_email?>" required name="user_email" type="text" class="text-input very-big-input w100" placeholder="<?=t('email_or_phone')?>">
        <input value="" required name="user_pass" type="password" class="text-input very-big-input w100" placeholder="<?=t('password')?>">
    </div>
    <div class="space20"></div>
    <button class="button primary-button very-big-button w100"><?=t('login')?></button>
    <div class="space20"></div>
    <div class="auth-form-text text-center nunito">
        <p class=""><?=t('forgot_your_password')?></p>
        <a href="/reset" class="hover primary-text underline "><?=t('reset_password')?></a>
    </div>
    <div class="space20"></div>
    <div class="form-messages nunito text-center">
        <div class="auth-form-error red-text bold"><?=$error?></div>
        <div class="auth-form-message green-text bold"><?=$message?></div>
    </div>
</form>
<!-- login -->