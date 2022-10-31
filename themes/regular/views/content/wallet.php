<script>
$(document).ready(function(){
    $('#topup_form').on('submit', function(e){
        let opt = $('#topup_form .form-select option:selected');
        let minAmount = parseInt(opt.attr('data-min'));
        let maxAmount = parseInt(opt.attr('data-max'));
        let amount = parseInt($('#topup_amount').val());
        
        if(amount === 0 || !amount) {
            e.preventDefault();
        } else if(minAmount > amount) {
            e.preventDefault();
            $('#form_error').text('Минимальная сумма пополнения - '+minAmount+'р.');
            $('#form_message').text('');
        } else if(maxAmount < amount) {
            e.preventDefault();
            $('#form_error').text('Максимальная сумма пополнения - '+maxAmount+'р.');
            $('#form_message').text('');
        } else {
            $('#form_error').text('');
            $('#form_message').text('Сейчас вы будете перенаправлены на страницу оплаты, следуйте инструкциям на странице платёжного сервиса.');
            setInterval(function(){
                $('#topup_amount').val('');
            }, 5000);
        }
    });
});
</script>
<form action='/wallet' id='topup_form' target="_blank" class='small-form' method='post'>
   <select required name='method' class='form-select'>
    <?php foreach($payment_methods as $method) { ?>
        <option data-comission='<?=$method['payment_method_comission']?>' data-min='<?=$method['min_topup_amount']?>' data-max='<?=$method['max_topup_amount']?>' value='<?=$method['payment_method_slug']?>'><?=$method['payment_method_name']?> (от <?=intval($method['min_topup_amount'])?>р., комиссия <?=$method['payment_method_comission']?>%)</option>
    <?php } ?>
    </select>
    <input style='margin: 20px 0;' placeholder="Сумма пополнения" name='amount' id='topup_amount' type='text' class='form-control'>
    <button class='btn btn-primary'>Пополнить</button>
    <p class='text-red' id='form_error' style='margin-top: 10px;'><?=$error?></p>
    <p class='text-green' id='form_message' style='margin-top: 5px;'><?=$true?></p>
</form>
<div style='height: 50px;'></div>
<h5>Пополнения</h5>
<?=$table?>