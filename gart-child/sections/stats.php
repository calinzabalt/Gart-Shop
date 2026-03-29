<?php
    $items = get_sub_field('items');
?>

<section class="stats">
    <div class="container">          
        <?php if(!empty($items)):?>
            <div class="flex">
                <?php foreach($items as $item):?>
                    <div class="col-25">
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