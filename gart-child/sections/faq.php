<?php
    $title = get_sub_field('title');
    $faq_items = get_sub_field('faq_items');
?>

<section class="faq">
    <div class="container">
        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($faq_items)):?>
            <div class="faq_wrapper">
                <?php foreach($faq_items as $faq):?>
                    <div class="faq_item">
                        <div class="faq_title">
                            <?php echo $faq['faq_title'];?>
                        </div>
                        <div class="faq_info">
                            <?php echo $faq['faq_info'];?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>

    </div>
</section>