<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // Добавляем мета-описание для главной страницы
    if (is_front_page()) {
        $meta_description = anich_get_setting('anich_homepage_description', 'Ассоциация Настольных Игр Челябинска (АНИЧ) - проводим игротеки, турниры, знакомим с настольными играми. Присоединяйтесь к нашему сообществу!');
        if (!empty($meta_description)) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
    }
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <span class="navbar-brand-text">АНИЧ</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                // Динамическое меню WordPress
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'navbar-nav ms-auto',
                    'fallback_cb' => 'anich_theme_fallback_menu',
                    'walker' => new Anich_Nav_Walker(),
                    'depth' => 2,
                ));
                ?>
            </div>
        </div>
    </nav>

