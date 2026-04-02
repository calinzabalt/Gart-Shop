<?php
    $label = get_sub_field('label');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $items = get_sub_field('items');

    $container_size = get_sub_field('container_size');
    $background_color = get_sub_field('background_color');

    $additional_class = '';

    if($container_size == 'small'){
        $additional_class = 'smaller';
    }

?>

<section class="boxes <?php echo $background_color;?>">
    <div class="container <?php echo $additional_class;?>">

        <?php if(!empty($label)):?>
            <div class="simple_label text-align-center">
                <span><?php echo $label;?></span>
            </div>
        <?php endif;?>

        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($description)):?>
            <p class="section_description text-align-center"><?php echo $description;?></p>
        <?php endif;?>
          
        <?php if(!empty($items)):?>
            <div class="flex">
                <?php foreach($items as $item):?>
                    <div class="col-33">
                        <div class="box">
                            <div class="icon">
                                <?php echo wp_get_attachment_image($item['icon'], 'large');?>
                            </div>
                            <div class="box_title">
                                <?php echo $item['item_title'];?>
                            </div>
                            <div class="box_description">
                                <p class="section_description">
                                    <?php echo $item['item_description'];?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</section>