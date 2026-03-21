<?php
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $explore_categories_repeater = get_sub_field('explore_categories_repeater');
?>

<section class="explore_categories">
    <div class="container">
        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($description)):?>
            <p class="section_description text-align-center"><?php echo $description;?></p>
        <?php endif;?>

        <?php if(!empty($explore_categories_repeater)):?>
            <div class="category_boxes">
                <?php foreach($explore_categories_repeater as $box):?>
                    <div class="cat col-25">
                        <a href="<?php echo $box['link'];?>">
                            <div class="overlay"></div>
                            <?php echo wp_get_attachment_image($box['image'], 'medium');?>

                            <div class="cat_desc">
                                <h4><?php echo $box['box_title'];?></h4>
                                <p><?php echo $box['box_subtitle'];?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</section>