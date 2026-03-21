<?php
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $label = get_sub_field('label');
?>

<section class="newsletter">
    <div class="container">

        <div class="label text-align-center">
            <span><?php echo $label;?></span>
        </div>

        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($description)):?>
            <p class="section_description text-align-center"><?php echo $description;?></p>
        <?php endif;?>

        <div class="blur-top-right"></div>
        <div class="blur-bottom-left"></div>
    </div>
</section>