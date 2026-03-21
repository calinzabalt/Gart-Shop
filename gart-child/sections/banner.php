<?php
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $button = get_sub_field('button');
    $button_title = $button['title'];
    $button_link = $button['url'];
    $overlay = get_sub_field('overlay');
?>

<section class="banner">
    <?php echo wp_get_attachment_image( get_sub_field('background_image'), 'full' ); ?>
    <div class="banner_content">
        <div class="container">
            <h1 class="banner_title"><?php echo $title;?></h1>

            <?php if(!empty($description)):?>
                <p class="banner_description"><?php echo $description;?></p>
            <?php endif;?>

            <?php if(!empty($button)):?>
                <div class="cta">
                    <a class="arrow_button" href="<?php echo $button_link;?>">
                        <?php echo $button_title;?>
                        <span>→</span>
                    </a>
                </div>
            <?php endif;?>   
        </div>
    </div>
    <?php if($overlay):?>
        <div class="gradient-overlay"></div>
    <?php endif;?>
</section>