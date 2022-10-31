<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <?php foreach($menu->items as $item) : ?>
    <li class="nav-item">
      <a class="nav-link <?=$item->active?>" href="<?=$item->url?>">
        <?=$item->icon?>
        <span><?=$item->title?></span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</aside>