<!-- faq -->
<div class="faq-list">
    <div>
        <?php if (!empty($faq)) {
            foreach ($faq as $faqModel) {
                echo $faqModel;
            }
        } else {
            echo '<div style="padding: 40px 0px; text-align: center;"><h3>No questions</h3></div>';
        } ?>
    </div>
    <div>
        <?php if (!empty($faq2)) {
            foreach ($faq2 as $faqModel) {
                echo $faqModel;
            }
        } ?>
    </div>
</div>
<div class="question-form faq-question-form">
<img src="/themes/purple/assets/images/flower-two.png" alt="" class="flower-faq-top">
<img src="/themes/purple/assets/images/flower-catalog.png" alt="" class="petal-faq-top">
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
        <button class="button primary-button very-big-button"><?= t('ask_question') ?></button>
        <div class="checkbox-block">
            <input name='agree_with_policy' type="checkbox" checked name="" id="">
            <?= t('agree_with_policy') ?>
        </div>
    </form>
</div>
<!-- faq -->