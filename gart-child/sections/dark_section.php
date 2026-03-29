<?php
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $button = get_sub_field('button');
?>

<section class="newsletter dark_section">
    <div class="container">
        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($description)):?>
            <p class="section_description text-align-center"><?php echo $description;?></p>
        <?php endif;?>

        <?php if(!empty($button)):?>
            <div class="cta">
                <a class="full_button" href="<?php echo $button['url'];?>">
                    <?php echo $button['title'];?>
                </a>
            </div>
        <?php endif;?>

        <div class="blur-top-right"></div>
        <div class="blur-bottom-left"></div>
    </div>
</section>