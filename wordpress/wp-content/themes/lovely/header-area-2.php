<!-- Start Header -->
<header class="header-area header-2">
    <div class="tw-menu-container">
        <div class="container">
            <?php lovely_logo(); ?>
            <a href="#" class="mobile-menu-icon"><span></span></a>
            <nav class="tw-menu"><?php
                lovely_menu();
                $header_social = lovely_option('header_social');
                if( $header_social != 'off' ){
                    echo lovely_social_icons();
                }
                echo lovely_searchmenu(); ?>
            </nav>
        </div>
    </div>
    <div class="header-clone"></div>         
</header>