<?php
    $items = get_sub_field('boxes');
?>

<section class="contact_boxes">
    <div class="container smaller">          
        <?php if(!empty($items)):?>
            <div class="flex">
                <?php foreach($items as $item):?>
                    <div class="col-33">
                        <div class="stat">
                            <div class="text">
                                <?php echo $item['text'];?>
                            </div>
                            <div class="info">
                                <?php echo $item['info'];?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</section>