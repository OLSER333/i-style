<?php

use App\Classes\Database\Value;

use function App\get_icon;
use function App\get_text;

$delete = '<a class="table-btn del" href="{URL}">'.get_icon('trash').'</a>';
$edit = '<a class="table-btn edit" href="{URL}">'.get_icon('edit').'</a>';

if(!isset($data['info_icon'])) {
    $data['info_icon'] = 'info2';
}
$info = '<a class="table-btn info" href="{URL}">'.get_icon($data['info_icon']).'</a>';

if(!isset($data['table_prepend_url'])) {
    $data['table_prepend_url'] = '/admin/'.$data['table_name'].'/';
}


if(isset($data['table_add_button']) and $data['table_add_button'] == true or isset($data['table_trash_button']) and $data['table_trash_button'] == true) { ?>
<div class='add-post'>
    <?php if($data['table_add_button'] == true) { ?>
    <a href='<?=$data['table_prepend_url']?>create' style='margin-bottom: 20px;' class='btn btn-primary'>Добавить</a>
    <?php } ?>
</div>
<?php } ?>

<div>
<div class='table table-box'>
    <table id="datatable" class="table datatable hover" style='width: 100%;'>
        <thead>
            <tr>
            <?php
            $table_data = $data['table_data'];
            if(!empty($table_data)) {
                foreach($table_data[0] as $column => $value) {
                    if($column != '_hidden')
                        echo "<th>".get_text($column)."</th>";
                }
                if(!empty($data['table_control']))
                    echo '<th>'.get_icon('sliders').'</th>';
            } else {
                echo "<th></th>";
            }
            ?>
            </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($table_data)) {
            foreach($table_data as $row) {
                if(!empty($row)) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if($key != '_hidden') {
                            if($value != '') {
                                echo "<td>".Value::get('string', $value, true, false)."</td>";
                            } else {
                                echo "<td>-</td>";
                            }
                        }
                    }
                    if(!empty($data['table_control'])) {
                        $row_control = '';
                        $id_key = $data['table_control_key'];
                        $id = $row[$id_key];
                        foreach($data['table_control'] as $control) {
                            if($control != 'info')
                                $row_control.= str_replace('{URL}', $data['table_prepend_url'].$control.'/'.$id, $$control);
                            else
                                $row_control.= str_replace('{URL}', $data['table_prepend_url'].$id, $$control);
                            
                        }
                        echo "<td><span class='table-control-col'>$row_control</span></td>";
                    }
                    echo "</tr>";
                }        
            }
        }
        ?>
        </tbody>
    </table>
</div>

<?php if(isset($data['table_trash_button'])) { ?>
    <div style='display: flex;' class='archive-cards'>
        <a style='margin-left: auto;' href='<?=$data['table_prepend_url']?>trash'>
            <i class="bi bi-trash"></i>
            Корзина (<?=intval($data['trash_count'])?>)
        </a>
    </div>
<?php } ?>
</div>