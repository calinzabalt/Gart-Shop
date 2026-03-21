<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php 
    $header_top = get_field('header_top', 'option');
    $drawer_title = get_field('drawer_title', 'option');
    $social_icons_title = get_field('social_icons_title', 'option');
    $social_icons = get_field('social_icons', 'option');
?>

<header class="header">
    <div class="top_bar">
        <div class="container">
            <p><?php echo $header_top;?></p>
        </div>
    </div>
    <div class="container">        
        <button id="drawer-toggle" class="drawer-toggle" aria-label="Open menu">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"></path></svg>
        </button>

        <nav class="main-nav flex item-center">
            <div class="nav-left">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_left',
                    'container' => false,
                ]);
                ?>
            </div>

            <div class="nav-logo">
                <?php the_custom_logo(); ?>
            </div>

            <div class="nav-right">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_right',
                    'container' => false,
                ]);
                ?>
            </div>
        </nav>
    </div>
</header>

<div class="drawer">
    <div class="drawer_wrapper">
        <div class="drawer_title">
            <?php echo $drawer_title;?>
        </div>
        <div class="drawer_close">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" viewBox="0 0 384 512"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
        </div>

        <?php
        wp_nav_menu([
            'theme_location' => 'menu_left',
            'container' => false,
        ]);
        ?>
        <?php
        wp_nav_menu([
            'theme_location' => 'menu_right',
            'container' => false,
        ]);
        ?>

        <div class="social_media">
            <span><?php echo $social_icons_title; ?></span>
            <div class="social_icons">
                <?php if($social_icons):?>
                    <?php foreach($social_icons as $icon):?>
                        <a href="<?php echo $icon['link'];?>" target="_blank">
                            <img src="<?php echo $icon['icon'];?>" alt="Social Icon">
                        </a>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>