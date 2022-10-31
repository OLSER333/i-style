
<form action='/payments' class='small-form' method='post'>
    <div class='d-flex'>
        <select required name='period' class='form-select'>
            <option value='week'>1 неделя, <?=$week_price?></option>
            <option value='month'>1 месяц, <?=$month_price?></option>
        </select>
        <button class='btn btn-primary'>Оплатить</button>
    </div>
    <p style='margin-top: 10px;'><?=$error?></p>
</form>
<div style='height: 50px;'></div>
<h5>Платежи</h5>
<?=$table?>