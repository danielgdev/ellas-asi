<!-- Start Header -->
<header class="header-area header-3">
    <div class="container">
        <div class="row top-bar">
            <div class="col-md-9">
                <?php lovely_top_menu(); ?>
            </div>
            <div class="col-md-3">
            <?php
                $header_social = lovely_option('header_social');
                if( $header_social != 'off' ){
                    echo lovely_social_icons();
                }
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php lovely_logo(); ?>
            </div>
            <div class="col-md-9">
                <?php 
                $ads = lovely_option("header_ads");
                if($ads){
                    echo '<div class="header-ads"><img src="'.$ads.'" alt="' . esc_attr(get_bloginfo('name')) . '"/></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="tw-menu-container">
        <div class="container">
            <a href="#" class="mobile-menu-icon"><span></span></a>
            <nav class="tw-menu"><?php
                lovely_menu();
                echo lovely_searchmenu(); ?>
            </nav>
        </div>
    </div>
    <div class="header-clone"></div>          
</header>