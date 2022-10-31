<form method="post">
    <p class='text-green'><?=$message?></p>
<?php
foreach($inputs as $key => $value) {
    echo "
        <label class='form-label'>
            <p>".App\get_text($key)."</p>
            <input class='form-control' type='text' value='$value' name='option[$key]'>
        </label>
    ";
} ?>
<button style='margin: 15px 0;' class='btn btn-primary'>Сохранить</button>
</form>