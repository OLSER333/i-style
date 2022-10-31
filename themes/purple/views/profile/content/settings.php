<!-- settings -->
<form id='settings_form' method="post" class='<?=$settings_form_hidden?>' action="">
    <input type="hidden" name="formname" value="<?=$formname?>">
    <div class="form-messages nunito ">
        <div class="auth-form-error red-text bold"><?=$error?></div>
        <div class="auth-form-message green-text bold"><?=$message?></div>
    </div>
    <div class="space10"></div>
    <div class="profile-form flex flex-start flex-wrap align-end gap-30-20 nunito">
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('first_name')?></div>
                <input name="first_name" value='<?=$first_name?>' type="text" class='text-input very-big-input'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('last_name')?></div>
                <input name="last_name" value='<?=$last_name?>' type="text" class='text-input very-big-input'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('phone')?></div>
                <input name="user_phone" value='<?=$user_phone?>' type="text" class='text-input very-big-input phone'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('city')?></div>
                <input id='search_location_js' name="contact_adress" value='<?=$contact_adress?>' type="text" placeholder="<?=t('location')?>" class='text-input very-big-input location-api'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('gender')?></div>
                <select name="user_gender" class='select-input white-select very-big-input'>
                    <option <?=selected($user_gender, 'female')?> value="female"><?=t('woman')?></option>
                    <option <?=selected($user_gender, 'male')?> value="male"><?=t('man')?></option>
                </select>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('birthday')?></div>
                <input name="user_birthday" value='<?=$user_birthday?>' placeholder="dd.mm.yyyy" type="text" class='text-input very-big-input date-dot'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('email')?></div>
                <input name="user_email" value='<?=$user_email?>' type="email" class='text-input very-big-input'>
            </label>
        </div>
        <div class="profile-form-item">
            <div id="change_password_button" class='button bda-button very-big-button hover flex-button-center'><div><?=t('change_password')?></div></div>
        </div>
        <div class="profile-form-item">
            <button class='button primary-button very-big-button'><?=t('save_changes')?></button>
        </div>
        <div class='profile-form-item'>
            <a href="/profile/logout" class="hover flex-button very-big-button profile-logout">
                <img class='mr10' src="/themes/purple/assets/images/logout-icon.svg" alt="">
                <div><?=t('logout_from_account')?></div>
            </a>
        </div>
    </div>
</form>
<form method="post" id='password_form' class='<?=$password_form_hidden?>' action="">
    <input type="hidden" name="password_form">
    <div class="form-messages nunito ">
        <div class="auth-form-error red-text bold"><?=$error?></div>
        <div class="auth-form-message green-text bold"><?=$message?></div>
    </div>
    <div class="space10"></div>
    <div class="profile-form flex flex-start flex-wrap align-end gap-30-20 nunito">
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('password')?></div>
                <input autocomplete="off" required name="user_pass" placeholder="********" type="password" class='text-input very-big-input'>
            </label>
        </div>
        <div class="profile-form-item">
            <label>
                <div class="input-title mb5"><?=t('password_confirm')?></div>
                <input autocomplete="off" required name="user_pass_confirm" placeholder="********" type="password" class='text-input very-big-input'>
            </label>
        </div>
        <div class="profile-form-item">
            <button class='button primary-button very-big-button'><?=t('save_changes')?></button>
        </div>
        <div class="profile-form-item">
            <div id="change_settings_button" class='button bda-button very-big-button hover flex-button-center'><div><?=t('change_account_info')?></div></div>
        </div>
    </div>
</form>
<script>
$(document).ready(function(){
    $('#change_password_button').on('click', function(){
        $('#settings_form').addClass('hidden');
        $('#password_form').removeClass('hidden');
    });
    $('#change_settings_button').on('click', function(){
        $('#password_form').addClass('hidden');
        $('#settings_form').removeClass('hidden');
    });
});
</script>
<!-- settings -->