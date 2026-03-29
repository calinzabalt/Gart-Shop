<?php
    $label = get_sub_field('label');
    $title = get_sub_field('title');
    $items = get_sub_field('items');
?>

<section class="boxes">
    <div class="container">

        <?php if(!empty($label)):?>
            <div class="simple_label text-align-center">
                <span><?php echo $label;?></span>
            </div>
        <?php endif;?>

        <h2 class="section_title text-align-center"><?php echo $title;?></h2>
          
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