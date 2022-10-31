<?php
foreach($data as $key => $value) {
    echo "<p><strong>".App\get_text($key)."</strong>: $value</p>";
}
