<!-- business -->
<form method="post" class="auth-form m-auto">
    <h2 class="h2 logo-tilda"><?=t('business_registration')?></h2>
    <div class="space40"></div>
    <div class="auth-radio-block nunito flex">
        <div class="w50">
            <p><?=t('choise_business_type')?></p>
        </div>
        <div class="w50 flex flex-start">
            <label class="checkbox-block max-content m-auto nunito">
                <input type="radio" value="salon" checked name="business_type" id="">
                <p><?=t('salon')?></p>
            </label>
            <label class="checkbox-block max-content m-auto nunito mr30">
                <input type="radio" value="master" name="business_type" id="">
                <p><?=t('master')?></p>
            </label>
        </div>
    </div>
    <div class="space20"></div>
    <div class="flex gap-10 flex-wrap form-inputs">
        <input value="<?=$salon_name?>" required name="salon_name" type="text" class="text-input very-big-input w100" placeholder="<?=t('salon_name_or_full_name_if_you_the_master')?>">
        <input value="<?=$boss_first_name?>" required name="boss_first_name" type="text" class="text-input very-big-input group-input" placeholder="<?=t('first_name')?>">
        <input value="<?=$boss_last_name?>" required name="boss_last_name" type="text" class="text-input very-big-input group-input" placeholder="<?=t('last_name')?>">
        <input value="<?=$user_phone?>" required name="user_phone" type="text" class="text-input very-big-input phone group-input" placeholder="<?=t('phone')?>">
        <input value="<?=$user_email?>" required name="user_email" type="email" class="text-input very-big-input group-input" placeholder="<?=t('email')?>">
        <input required name="user_pass" type="password" class="text-input very-big-input group-input" placeholder="<?=t('password')?>">
        <input required name="user_pass_confirm" type="password" class="text-input very-big-input group-input" placeholder="<?=t('confirm_password')?>">
    </div>
    <div class="space20"></div>
    <button class="button primary-button very-big-button w100"><?=t('create_profile')?></button>
    <div class="space10"></div>
    <label class="checkbox-block max-content m-auto nunito">
        <input checked type="checkbox" name="agree_checked" value="1" id="">
        <p><?=t('i_agree_with_the_personal_data_processing_policy')?></p>
    </label>
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
<!-- business -->