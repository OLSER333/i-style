<!-- registration -->
<form method="post" class="auth-form m-auto">
    <h2 class="h2 logo-tilda"><?=t('register')?></h2>
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
    <div class="flex gap-10 flex-wrap form-inputs">
        <input value="<?=$first_name?>" required name="first_name" type="text" class="text-input very-big-input group-input" placeholder="<?=t('first_name')?>">
        <input value="<?=$last_name?>" required name="last_name" type="text" class="text-input very-big-input group-input" placeholder="<?=t('last_name')?>">
        <input value="<?=$user_phone?>" required name="user_phone" type="text" class="text-input very-big-input  group-input phone" placeholder="<?=t('phone')?>">
        <input value="<?=$user_email?>" required name="user_email" type="email" class="text-input very-big-input group-input" placeholder="<?=t('email')?>">
        <input value="" required name="user_pass" type="password" class="text-input very-big-input group-input" placeholder="<?=t('password')?>">
        <input value="" required name="user_pass_confirm" type="password" class="text-input very-big-input group-input" placeholder="<?=t('confirm_password')?>">
    </div>
    <div class="space20"></div>
    <button class="button primary-button very-big-button w100"><?=t('create_profile')?></button>
    <div class="space10"></div>
    <label class="checkbox-block max-content m-auto nunito">
        <input checked type="checkbox" name="agree_checked" value="1" id="">
        <p><?=t('i_agree_with_the_personal_data_processing_policy')?></p>
    </label>
    <div class="space30"></div>
    <a href="/business" class="button brown-button very-big-button w100"><?=t('registration_for_business')?></a>
    <div class="space30"></div>
    <div class="auth-form-text text-center nunito">
        <p class=""><?=t('already_register')?></p>
        <a href="/sign_in" class="hover primary-text underline "><?=t('do_login')?></a>
    </div>
    <div class="space20"></div>
    <div class="form-messages nunito text-center">
        <div class="auth-form-error red-text bold"><?=$error?></div>
        <div class="auth-form-message green-text bold"><?=$message?></div>
    </div>
</form>
<!-- registration -->