<?php
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $contact_information = get_sub_field('contact_information');
    $social_media_title = get_sub_field('social_media_title');
    $social_media_links = get_sub_field('social_media_links');
    $contact_form_title = get_sub_field('contact_form_title');
    $form_shortcode = get_sub_field('contact_form_shortcode');
?>

<section class="contact_us">
    <div class="container">
        <div class="flex">
            <div class="col-50">
                <h2 class="section_title"><?php echo $title;?></h2>

                <?php if(!empty($description)):?>
                    <p class="section_description"><?php echo $description;?></p>
                <?php endif;?>

                <?php if(!empty($contact_information)):?>
                    <div class="items">
                        <?php foreach($contact_information as $info):?>
                            <div class="item">
                                <div class="left">
                                    <div class="item_icon">
                                        <?php echo wp_get_attachment_image($info['icon'], 'large');?>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="item_title">
                                        <?php echo $info['text'];?>
                                    </div>
                                    <div class="item_info">
                                        <?php echo $info['info'];?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>   

                <?php if(!empty($social_media_title)):?>
                    <div class="social_title">
                        <?php echo $social_media_title;?>
                    </div>
                <?php endif;?>

                <?php if(!empty($social_media_links)):?>
                    <div class="social_square_links">
                        <?php foreach($social_media_links as $social_link):?>
                            <div class="social_link">
                                <a href="<?php echo $social_link['social']['url'];?>" target="_blank"><?php echo $social_link['social']['title'];?></a>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>

            </div>
            <div class="col-50">
                <div class="contact_form_wrapper">
                    <?php if(!empty($contact_form_title)):?>
                        <h3><?php echo $contact_form_title;?></h3>
                    <?php endif;?>
                    <?php echo do_shortcode($form_shortcode);?>
                </div>
            </div>
        </div>
    </div>
</section>