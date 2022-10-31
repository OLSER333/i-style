<!-- recovery -->
<form method="post" class="auth-form m-auto">
    <h2 class="h2 logo-tilda"><?=t('password_reset')?></h2>
    <div class="space10"></div>
    <h3 class="bold gray-text text-center lh15"><?=t('enter_your_phone_or_email_that_you_used_to_enter_the_site')?></h3>
    <div class="space30"></div>
    <div class="flex gap-10">
        <input value="<?=$user_email?>" required name="user_email" type="text" class="text-input very-big-input w100" placeholder="<?=t('email_or_phone')?>">
    </div>
    <div class="space20"></div>
    <button class="button primary-button very-big-button w100"><?=t('reset_password')?></button>
    <div class="space20"></div>
    <div class="form-messages nunito text-center">
        <div class="auth-form-error red-text bold"><?=$error?></div>
        <div class="auth-form-message green-text bold"><?=$message?></div>
    </div>
</form>
<!-- recovery -->