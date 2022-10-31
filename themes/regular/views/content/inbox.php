<div class="w100">
<div class='space-20'></div>
<div class="chat">
 
    <div class="chat-body">
        <?php

use App\Classes\Database\Value;

use function App\text_translate;
use function App\get_letter_color;
use function App\get_text;

 if(trim($_SERVER['REQUEST_URI'], '/') == 'inbox') {
            echo ' <div class="no-messages">'.get_text('get_chat').'</div>';
         } else { ?>
               
<script>
$(document).ready(function(){
    $('#new_msg').submit(function(e){
        e.preventDefault();
        if($.trim($('#msg_text').val()) == '') {
            return false;
        }
        let message = $('#msg_text').val().replaceAll(/\r\n|\r|\n/g,"<br>");
        $('#msg_text').val('')
        $.ajax({
            method: 'post',
            data: {
                'new_message': message
            },
            success: function(){
                chatUpdate();
            }
        });
    });
    let div = $('.messages-chats');
    div.scrollTop(div.prop('scrollHeight'));

    setInterval(function(){
        chatUpdate();
    }, 6000);

});
function chatUpdate()
{
    let div = $('.messages-chats');
    $.ajax({
            method: 'GET',
            dataType: "html",
            error: function(){
                alert('chat_error');
            },
            beforeSend: function(){
                $('.notice').fadeTo(300, 0.6);
            },
            success: function(data) {
                let messages = $(data).find('.messages-chats').html();
                let chat = $(data).find('.chat-list').html();
                let notice = $(data).find('.notice').html();
                if($(div).scrollTop() >= $(div).prop('scrollHeight') - 400) {
                    var scroll = true;
                } else {
                    var scroll = false;
                }
                div.html(messages);
                $('.chat-list').html(chat);
                $('.notice').html(notice);
                $('.notice').fadeTo(300, 1);
                if(scroll == true)
                    div.scrollTop(div.prop('scrollHeight'));
                // div.fadeTo(100, 1);
            }
        
        });
}
</script>
        <div class="messages-chats">

<?php
if(!empty($page_data['page_chat_array']['messages'])) { foreach($page_data['page_chat_array']['messages'] as $message) :
    if(isset($message['message_user'])) {
?>
            <div class='message-chat-item user'>
                <p><?=htmlspecialchars_decode($message['chat_message_text'])?></p>
                <div class='message-chat-item-footer'>
                    <div class='width-wrapper-right'>
                        <div class='message-user-name'>
<?php
$chat_message_user_name = text_translate($message['message_user']['full_name']);
$user_first_letter = mb_substr($chat_message_user_name, 0, 1);
$letter_color = get_letter_color($user_first_letter);
?>
                            <span style='background-color: <?=$letter_color?>;' class="user-circle"><?=ucfirst($user_first_letter)?></span><?=$message['message_user']['full_name']?>
                        </div>
                        <div class='message-time'>
                            <?=Value::get('unix', $message['chat_message_date_add'])?>
                        </div>
                    </div>
                </div>
            </div>
<?php
    } else {
?>
            <div class='message-chat-item self'>
                <p><?=htmlspecialchars_decode($message['chat_message_text'])?></p>
                <div class='message-chat-item-footer'>
                    <div class='width-wrapper-right'>
                        <div class='message-time'>
                            <?=Value::get('unix', $message['chat_message_date_add'])?>
                        </div>
                    </div>
                </div>
            </div>
<?php
    }
?>
         
<?php
endforeach;
} else {
?>
            <div class="no-messages"><?=get_text('no_msg')?></div>
<?php } ?>
        </div>
        <div class="control">
            <form action="" method="POST" id='new_msg' class="form">
                <textarea id='msg_text' name='new_message' placeholder="<?=get_text('type_here')?>" class="form-input chat-input"></textarea>
                <button class="chat-button"><i class="fas fa-share"></i></button>
            </form>
        </div>

        <?php } ?>
    </div>
    <div class="chat-sidebar">
        <div class="chat-list">
<?php
if(is_array($page_data['chats']) and !empty($page_data['chats']))
    foreach($page_data['chats'] as $chat) :
        // $circle_letter = $chat['chat_users_name_arr'][0][0];
        if($chat['chat_id'] == $page_data['page_chat_id']) {
            $active = 'active';
        } else {
            $active = '';
        }
?>
            <a href='/inbox/<?=$chat['chat_id']?>'>
                <div class="chat-list-item <?=$active?>">
<?php
        foreach($chat['chat_users_name_arr'] as $chat_user_name) :
            $name = text_translate($chat_user_name);
            $user_first_letter = mb_substr($name, 0, 1);
            $letter_color = get_letter_color($user_first_letter);
?>
                <div class='chat-list-user-name-item'>
                    <span style='background-color: <?=$letter_color?>' class="user-circle"><?=ucfirst($user_first_letter)?></span>
                    <span class='chat-list-text'><?=$chat_user_name?></span>
                </div>
        <?php endforeach; ?>
                    
        <?php if($chat['new_messages_count'] == 0) { ?>
                    <div class='chat-list-new-count'>+<?=$chat['new_messages_count']?></div>
        <?php } else { ?>
                    <div class='chat-list-new-count active'>+<?=$chat['new_messages_count']?></div>
        <?php } ?>
                </div>
            </a>
<?php
    endforeach;
else
    echo '<div class="no-chats">'.get_text('no_chats').'</div>'; 
?>

        </div>
    </div>
</div>
</div>