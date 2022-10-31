<?php
if(isset($data)) foreach($data as $key => $value) {
    echo "<p><strong>".App\get_text($key)."</strong>: $value</p>";
}
?>
<p style='font-weight: 600; font-size: 16px;'><?=$message?></p>
<a href='?conf=true' class='btn btn-primary'>Удалить</a>