<?php
    $title = get_sub_field('title');
    $map = get_sub_field('map_iframe');
?>

<section class="map">
    <div class="container">
        <h2 class="section_title text-align-center"><?php echo $title;?></h2>

        <div class="map_wrapper">
            <?php echo $map;?>
        </div>

    </div>
</section>