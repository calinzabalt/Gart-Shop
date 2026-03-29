<?php
    $image_position = get_sub_field('image_position');
    $label = get_sub_field('label');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $image = get_sub_field('image');
    $button = get_sub_field('button');
?>

<section class="image_text">
    <div class="container">
        <div class="flex image_position_<?php echo $image_position;?>">
            <div class="col-50">
                <?php if(!empty($label)):?>
                    <div class="simple_label">
                        <span><?php echo $label;?></span>
                    </div>
                <?php endif;?>

                <h2 class="section_title"><?php echo $title;?></h2>

                <?php if(!empty($description)):?>
                    <p class="section_description"><?php echo $description;?></p>
                <?php endif;?>

                <?php if(!empty($button)):?>
                    <a class="arrow_button" href="<?php echo $button['url'];?>">
                        <?php echo $button['title'];?>
                        <span>→</span>
                    </a>
                <?php endif;?>
            </div>

            <div class="col-50">
                <div class="image">
                    <?php echo wp_get_attachment_image($image, 'large');?>
                </div>
            </div>
        </div>
    </div>
</section>