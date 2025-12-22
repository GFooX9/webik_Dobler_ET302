<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php
    // Добавляем мета-описание для главной страницы
    if (is_front_page()) {
        $meta_description = wolf_get_setting('wolf_homepage_description', 'WOLF - Narrative Drama Game от студии HotKeysGames. Погрузитесь в мрачный и пронзительный литературный мир.');
        if (!empty($meta_description)) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
    }
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top custom-nav">
        <div class="container">
            <a class="navbar-brand wolf-logo" href="<?php echo esc_url(home_url('/')); ?>">
                <?php 
                $logo_url = wolf_get_image_url('wolf_logo_game', 'Materials/Icons for futter and header/Logo game.svg');
                if ($logo_url) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Логотип игры WOLF" class="wolf-logo-img">
                <?php endif; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <?php
                // Динамическое меню WordPress
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'navbar-nav align-items-center',
                    'fallback_cb' => 'wolf_theme_fallback_menu',
                    'walker' => new Wolf_Nav_Walker(),
                    'depth' => 2,
                ));
                ?>
            </div>
        </div>
    </nav>

