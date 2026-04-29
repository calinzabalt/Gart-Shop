<?php
    $footer_logo = gart_get_option('footer_logo');
    $footer_description = gart_get_option('footer_description');
    $footer_menu_1_title = gart_get_option('footer_menu_1_title');
    $footer_menu_1 = gart_get_option('footer_menu_1');

    $footer_menu_2_title = gart_get_option('footer_menu_2_title');
    $footer_menu_2 = gart_get_option('footer_menu_2');

    $footer_menu_3_title = gart_get_option('footer_menu_3_title');
    $footer_menu_3 = gart_get_option('footer_menu_3');

    $social_icons = gart_get_option('social_icons');
?>    
    <footer id="site-footer" class="site-footer">
        <div class="container">
            <div class="footer_top">
                <div class="flex">
                    <div class="col-25">
                        <div class="footer_logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php echo wp_get_attachment_image($footer_logo, 'medium');?>
                            </a>
                        </div>
                        <div class="footer_description">
                            <p><?php echo $footer_description;?></p>
                        </div>
                    </div>
                    <div class="col-25">
                        <div class="menu_title">
                            <?php echo $footer_menu_1_title;?>
                        </div>
                        <div class="menu_items">
                            <ul>
                                <?php foreach($footer_menu_1 as $menu):?>
                                    <li>
                                        <a href="<?php echo $menu['menu']['url'];?>">
                                            <?php echo $menu['menu']['title'];?>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-25">
                        <div class="menu_title">
                            <?php echo $footer_menu_2_title;?>
                        </div>
                        <div class="menu_items">
                            <ul>
                                <?php foreach($footer_menu_2 as $menu):?>
                                    <li>
                                        <a href="<?php echo $menu['menu']['url'];?>">
                                            <?php echo $menu['menu']['title'];?>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-25">
                        <div class="menu_title">
                            <?php echo $footer_menu_3_title;?>
                        </div>
                        <div class="menu_items">
                            <ul>
                                <?php foreach($footer_menu_3 as $key => $menu):?>
                                    <li>
                                        <a href="<?php echo $menu['menu']['url'];?>">
                                            <?php if($key == 0):?>
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path></svg>
                                            <?php endif;?>
                                            <?php if($key == 1):?>
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" class="svg-inline--fa fa-envelope w-4 h-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path></svg> 
                                            <?php endif;?>
                                            <?php if($key == 2):?>
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" class="svg-inline--fa fa-location-dot w-4 h-4 mt-1" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path></svg>
                                            <?php endif;?>
                                            <?php echo $menu['menu']['title'];?>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <p>© <?php echo date('Y'); ?> Gart. <?php echo ( function_exists('pll_current_language') && pll_current_language() === 'en' ) ? 'All rights reserved.' : 'Toate drepturile rezervate.'; ?></p> 

                <div class="social_media">
                    <div class="social_icons">
                        <?php if($social_icons):?>
                            <?php foreach($social_icons as $icon):?>
                                <a href="<?php echo $icon['link'];?>" target="_blank">
                                    <img src="<?php echo $icon['icon'];?>" alt="Social Icon">
                                </a>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>