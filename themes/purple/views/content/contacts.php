<!-- contacts -->
<div class="contacts-info-right-image">
    <img src="/themes/purple/assets/images/contacts-right.png" alt="">
    <img src="/themes/purple/assets/images/flower-two.png" alt="" class="flower-contacs-top">
</div>
<div class="contacts-info">

    <div class="contacts-phone">
        <div class="contacts-info-image"><img src="/themes/purple/assets/images/phone-circle.svg"></div>
        <div class="contacts-info-row">
            <div><?= t('contact_phone') ?>:</div>
            <div><?= $phone ?></div>
        </div>
    </div>
    <div class="contacts-requisites">
        <div class="contacts-info-image contacts-info-image-two"><img src="/themes/purple/assets/images/icon-circle.svg"></div>
        <div class="contacts-info-row">
            <div><?= t('requisites') ?>:</div>
            <div><?= $requisites ?></div>
        </div>
    </div>
</div>
<div class="question-form">
    <div class="question-form-title">
        <h2 class="logo-tilda"><?= t('ask_question_for_us') ?></h2>
    </div>
    <form action="">
        <div class="question-form-personal-data">
            <input name='name' placeholder="<?= t('your_name') ?>" type="text" class="text-input very-big-input question-input">
            <input name='email' placeholder="<?= t('E-mail') ?>" type="text" class="text-input very-big-input question-input">
            <input name='question_topic' placeholder="<?= t('question_topic') ?>" type="text" class="text-input very-big-input question-input">
        </div>
        <textarea name='question_description' placeholder="<?= t('question_description') ?>" class='text-input'></textarea>
        <button class="button primary-button very-big-button w100"><?= t('ask_question') ?></button>
        <div class="checkbox-block">
            <input name='agree_with_policy' type="checkbox" checked name="" id="">
            <?= t('agree_with_policy') ?>
        </div>
    </form>
</div>
<!-- contacts -->