<!-- topup -->
<div data-id='<?=$topup_id?>' data-active-class='<?=$active_class?>' data-open-button-class='<?=$open_button?>' class="topup-wrapper flex flex-center">
    <div class="topup-content-container">
        <div class="topup-content">
            <?=$content?>
        </div>
    </div>
</div>
<script>topup($('[data-id=<?=$topup_id?>]'), '<?=$open_button?>', '<?=$active_class?>');</script>
<!-- topup -->