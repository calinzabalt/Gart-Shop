<?php
    $label = get_sub_field('label');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $additional_text = get_sub_field('additional_text');
    $form_shortcode = get_sub_field('form_shortcode');
?>

<section class="contact_b2b">
    <div class="container">

        <?php if(!empty($label)):?>
            <div class="simple_label text-align-center">
                <span><?php echo $label;?></span>
            </div>
        <?php endif;?>

        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <?php if(!empty($description)):?>
            <p class="section_description text-align-center"><?php echo $description;?></p>
        <?php endif;?>
          
        <?php if(!empty($additional_text)):?>
            <span class="additional_text text-align-center"><?php echo $additional_text;?></span>
        <?php endif;?>

        <div class="contact_form_wrapper">
            <?php echo do_shortcode($form_shortcode);?>
        </div>

    </div>
</section>