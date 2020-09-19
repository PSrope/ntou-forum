<?php

require_once(__DIR__ . '/../includes/configs.php');

// $menu_home = ['url' => '#', 'class_name' => 'fas fa-edit'];
// $menu_logout = ['url' => 'logout.php', 'class_name' => 'fas fa-edit'];
// $menu_user = ['url' => '', 'class_name' => 'fas fa-edit'];
// $menu_post = ['url' => '#', 'class_name' => 'fas fa-edit'];

$menu_items = array(
    ['url' => 'new_post.php', 'class_name' => 'fas fa-edit'],
    ['url' => 'logout.php', 'class_name' => 'fas fa-sign-out-alt'],
    ['url' => 'user.php', 'class_name' => 'fas fa-user']
);

?>

<!DOCTYPE html>
<ul id="menu">
    <a class="menu-button icon-plus" href="#menu" title="Show navigation">
        <i class="fas fa-bars"></i>
    </a>
    <a class="menu-button icon-minus" href="#0" title="Hide navigation">
        <i class="fas fa-bars"></i>
    </a>

    <li class="menu-item">
        <a href="<?php echo $menu_items[0]['url']; ?>">
            <i class="<?php echo $menu_items[0]['class_name']; ?>"></i>
        </a>
    </li>

    <li class="menu-item">
        <a href="<?php echo $menu_items[1]['url']; ?>">
            <i class="<?php echo $menu_items[1]['class_name']; ?>"></i>
        </a>
    </li>

    <li class="menu-item">
        <a href="<?php echo $menu_items[2]['url']; ?>">
            <i class="<?php echo $menu_items[2]['class_name']; ?>"></i>
        </a>
    </li>
</ul>
