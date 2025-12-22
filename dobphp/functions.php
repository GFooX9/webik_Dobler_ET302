<?php
/**
 * WOLF Game Theme Functions
 *
 * @package WOLF_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Регистрация стилей и скриптов темы
 */
function wolf_theme_enqueue_scripts() {
    // Регистрация стилей
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_style('wolf-theme-style', get_stylesheet_uri(), array('bootstrap-css', 'font-awesome'), '1.0');
    
    // Регистрация скриптов
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    
    // Регистрация основного скрипта темы
    wp_enqueue_script('wolf-theme-script', get_template_directory_uri() . '/script.js', array('bootstrap-js'), '1.0', true);
    
    // Локализация скрипта для передачи данных в JavaScript (должна быть после регистрации)
    wp_localize_script('wolf-theme-script', 'wolfTheme', array(
        'templateUri' => get_template_directory_uri(),
    ));
}
add_action('wp_enqueue_scripts', 'wolf_theme_enqueue_scripts');

/**
 * Поддержка функций темы
 */
function wolf_theme_setup() {
    // Поддержка заголовка документа
    add_theme_support('title-tag');
    
    // Поддержка миниатюр записей
    add_theme_support('post-thumbnails');
    
    // Поддержка HTML5 разметки
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Поддержка автоматического обновления ссылок в RSS
    add_theme_support('automatic-feed-links');
    
    // Поддержка WYSIWYG редактора (включено по умолчанию, но явно указываем)
    add_theme_support('editor-styles');
    add_editor_style('style.css');
    
    // Поддержка широкого и полного выравнивания контента
    add_theme_support('align-wide');
    
    // Поддержка цветовой палитры для редактора
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Основной беж', 'wolf-theme'),
            'slug' => 'primary-beige',
            'color' => '#e8e2d2',
        ),
        array(
            'name' => __('Шалфей', 'wolf-theme'),
            'slug' => 'sage',
            'color' => '#93a38e',
        ),
        array(
            'name' => __('Черный', 'wolf-theme'),
            'slug' => 'black',
            'color' => '#000000',
        ),
    ));
}
add_action('after_setup_theme', 'wolf_theme_setup');

/**
 * Регистрация меню навигации
 */
function wolf_theme_menus() {
    register_nav_menus(array(
        'primary' => __('Основное меню', 'wolf-theme'),
    ));
}
add_action('init', 'wolf_theme_menus');

/**
 * Кастомный Walker для меню навигации с поддержкой классов Bootstrap
 */
class Wolf_Nav_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'nav-item';
        
        // Добавляем классы Bootstrap
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }
        
        // Проверяем, является ли это элементом с иконкой VK
        if (stripos($item->title, 'VK') !== false || stripos($item->url, 'vk') !== false) {
            $classes[] = 'ms-lg-2';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        // Определяем классы для ссылки
        $link_classes = array('nav-link');
        
        // Проверяем, является ли это элементом с иконкой VK
        if (stripos($item->title, 'VK') !== false || stripos($item->url, 'vk') !== false) {
            $link_classes[] = 'social-icon';
        } else {
            $link_classes[] = 'btn-pill';
        }
        
        // Проверяем, является ли это модальным окном поддержки
        if (stripos($item->url, '#') === false && stripos($item->title, 'ПОДДЕРЖКА') !== false) {
            $attributes .= ' data-bs-toggle="modal" data-bs-target="#supportModal"';
        }
        
        $link_class = ! empty($link_classes) ? ' class="' . esc_attr(join(' ', $link_classes)) . '"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . $link_class .'>';
        
        // Если это VK, добавляем иконку
        if (stripos($item->title, 'VK') !== false || stripos($item->url, 'vk') !== false) {
            // Используем иконку VK из папки Materials (она не редактируется через Customizer)
            $item_output .= '<img src="' . esc_url(get_template_directory_uri()) . '/Materials/Icons for futter and header/Vk.svg" alt="VK" class="header-vk-logo">';
        } else {
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Добавление поддержки редактирования контента страниц через WYSIWYG редактор
 */
function wolf_theme_add_editor_support() {
    // Включаем поддержку редактора для всех типов постов
    add_post_type_support('page', 'editor');
    add_post_type_support('post', 'editor');
}
add_action('init', 'wolf_theme_add_editor_support');

/**
 * Фильтр для улучшения работы WYSIWYG редактора
 */
function wolf_theme_tiny_mce_before_init($init) {
    // Добавляем дополнительные стили в редактор
    $init['body_class'] = 'wolf-editor-content';
    
    // Разрешаем больше HTML тегов
    $init['extended_valid_elements'] = 'script[src|async|defer|type|charset],style[type],iframe[src|width|height|name|align],object[width|height|data|type],param[name|value],embed[src|type|width|height],video[src|poster|preload|controls|width|height],audio[src|preload|controls],source[src|type],track[src|kind|srclang|label|default]';
    
    return $init;
}
add_filter('tiny_mce_before_init', 'wolf_theme_tiny_mce_before_init');

/**
 * Добавление стилей для редактора
 */
function wolf_theme_add_editor_styles() {
    add_editor_style('style.css');
}
add_action('admin_init', 'wolf_theme_add_editor_styles');

/**
 * Fallback меню, если меню не создано в админке
 */
function wolf_theme_fallback_menu() {
    ?>
    <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link btn-pill" href="#about">О ИГРЕ</a></li>
        <li class="nav-item"><a class="nav-link btn-pill" href="#gallery">ГАЛЕРЕЯ</a></li>
        <li class="nav-item"><a class="nav-link btn-pill" href="#team">КОМАНДА</a></li>
        <li class="nav-item"><a class="nav-link btn-pill" href="#" data-bs-toggle="modal" data-bs-target="#supportModal">ПОДДЕРЖКА</a></li>
        <li class="nav-item ms-lg-2">
            <a class="nav-link social-icon" href="<?php echo esc_url(wolf_get_setting('wolf_vk_url', '#')); ?>" aria-label="VK" target="_blank" rel="noopener noreferrer">
                <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for futter and header/Vk.svg" alt="VK" class="header-vk-logo">
            </a>
        </li>
    </ul>
    <?php
}

/**
 * Добавление поддержки виджетов (опционально)
 */
function wolf_theme_widgets_init() {
    register_sidebar(array(
        'name' => __('Боковая панель', 'wolf-theme'),
        'id' => 'sidebar-1',
        'description' => __('Добавьте виджеты сюда.', 'wolf-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'wolf_theme_widgets_init');

// ===== НАСТРОЙКИ ТЕМЫ ДЛЯ РЕДАКТИРУЕМОГО КОНТЕНТА (Customizer API) =====

/**
 * Регистрация настроек темы через Customizer API
 */
function wolf_theme_customize_register($wp_customize) {
    
    // === Секция: Контактная информация ===
    $wp_customize->add_section('wolf_contacts', array(
        'title' => __('Контактная информация', 'wolf-theme'),
        'priority' => 30,
    ));
    
    // VK ссылка
    $wp_customize->add_setting('wolf_vk_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wolf_vk_url', array(
        'label' => __('Ссылка на VK', 'wolf-theme'),
        'section' => 'wolf_contacts',
        'type' => 'url',
    ));
    
    // Discord ссылка
    $wp_customize->add_setting('wolf_discord_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wolf_discord_url', array(
        'label' => __('Ссылка на Discord', 'wolf-theme'),
        'section' => 'wolf_contacts',
        'type' => 'url',
    ));
    
    // Steam ссылка
    $wp_customize->add_setting('wolf_steam_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wolf_steam_url', array(
        'label' => __('Ссылка на Steam', 'wolf-theme'),
        'section' => 'wolf_contacts',
        'type' => 'url',
    ));
    
    // Facebook ссылка
    $wp_customize->add_setting('wolf_facebook_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('wolf_facebook_url', array(
        'label' => __('Ссылка на Facebook', 'wolf-theme'),
        'section' => 'wolf_contacts',
        'type' => 'url',
    ));
    
    // === Секция: Тексты секций ===
    $wp_customize->add_section('wolf_sections', array(
        'title' => __('Тексты секций', 'wolf-theme'),
        'priority' => 31,
    ));
    
    // Текст кнопки предзаказа
    $wp_customize->add_setting('wolf_preorder_button_text', array(
        'default' => 'ОФОРМИТЬ<br>ПРЕДЗАКАЗ',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_preorder_button_text', array(
        'label' => __('Текст кнопки предзаказа', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
        'description' => __('Используйте &lt;br&gt; для переноса строки', 'wolf-theme'),
    ));
    
    // Текст "О ИГРЕ" для больших экранов - Абзац 1
    $wp_customize->add_setting('wolf_about_text_1', array(
        'default' => 'Wolf — это повествовательная драма от студии HotKeysGames, которая переносит на игровой холст мрачный и пронзительный литературный мир. История игры рождается из страниц культовой серии книг «Unhappy stories» российского писателя Александра Доблера. Мы бережно сохранили уникальную атмосферу его прозы — гнетущее очарование юга Европы, психологическую глубину персонажей и философское осмысление хрупкости человеческих судеб.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_about_text_1', array(
        'label' => __('О ИГРЕ - Абзац 1 (большие экраны)', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст "О ИГРЕ" для больших экранов - Абзац 2
    $wp_customize->add_setting('wolf_about_text_2', array(
        'default' => 'Действие разворачивается в вымышленной стране на юге Европы в середине XX века. Время, когда старый мир трещит по швам, а новый еще не родился. Здесь, под палящим солнцем и в тени старых вилл, начинается взросление юного героя. Его первые шаги во взрослую жизнь неожиданно становятся шагами в лабиринт прошлого — прошлого его родителей, полного болезненных тайн, невысказанных обид и решений, которые отзываются эхом спустя десятилетия.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_about_text_2', array(
        'label' => __('О ИГРЕ - Абзац 2 (большие экраны)', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст "О ИГРЕ" для больших экранов - Абзац 3
    $wp_customize->add_setting('wolf_about_text_3', array(
        'default' => 'Игрокам предстоит не просто пройти сюжет, а распутать сложнейший клубок из множества человеческих историй. Каждый новый знакомый, каждая найденная записка, каждый полунамёк в разговоре — это нить, которая может привести как к прозрению, так и к новой ловушке. Судьбы родителей, их любовь, предательство, надежды и страх сплетаются с собственной жизнью героя, заставляя его задавать главные вопросы: Кто мы — продолжатели судеб наших родителей или заложники их ошибок? Можно ли разорвать порочный круг, если его истоки скрыты во тьме прошлого?',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_about_text_3', array(
        'label' => __('О ИГРЕ - Абзац 3 (большие экраны)', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст "О ИГРЕ" для малых экранов
    $wp_customize->add_setting('wolf_about_text_small', array(
        'default' => 'Игра "Wolf" была создана компанией HotKeysGames по мотивам серии книг Unhappy stories, автором которой является российский писатель Доблер Александр. Игра рассказывает историю происходящую в вымышленной стране на юге Европы 20 века, где подросток начинает взрослую жизнь, которая тесно переплетается с прошлым его родителей. По ходу игры, с развитием сюжета игрокам предстоит распутать клубок, сплетенный из множества человеческих историй.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_about_text_small', array(
        'label' => __('О ИГРЕ - Текст для малых экранов', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст галереи для больших экранов
    $wp_customize->add_setting('wolf_gallery_text_large', array(
        'default' => 'Иногда стоит остановиться, чтобы увидеть всё великолепие этого мира. Мы представляем наброски из нашей галереи, которые в будущем будут реализованы. Здесь собраны все арты, концепты, персонажи и воспоминания, которые вам удалось открыть по ходу игры. Исследуйте разделы, чтобы увидеть детали мира, узнать больше о героях и пережить ключевые моменты истории снова. Некоторые элементы скрыты — чтобы их найти, понадобится внимание и смекалка. Собирайте коллекцию полностью!',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_gallery_text_large', array(
        'label' => __('ГАЛЕРЕЯ - Текст для больших экранов', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст галереи для малых экранов
    $wp_customize->add_setting('wolf_gallery_text_small', array(
        'default' => 'Иногда стоит остановиться, чтобы увидеть всё великолепие этого мира. Мы представляем наброски из нашей галереи, которые в будущем будут реализованы. Здесь собраны все арты, концепты, персонажи и воспоминания, которые вы откроете по ходу игры.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_gallery_text_small', array(
        'label' => __('ГАЛЕРЕЯ - Текст для малых экранов', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // Текст команды
    $wp_customize->add_setting('wolf_team_text', array(
        'default' => 'Создание игры — это история о том, как разные люди с разными навыками объединяются ради общей цели: подарить миру новые эмоции, новые миры и новые приключения. Команда — это и есть настоящая магия геймдева.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_team_text', array(
        'label' => __('КОМАНДА - Описание', 'wolf-theme'),
        'section' => 'wolf_sections',
        'type' => 'textarea',
    ));
    
    // === Секция: Форма предзаказа ===
    $wp_customize->add_section('wolf_preorder', array(
        'title' => __('Форма предзаказа', 'wolf-theme'),
        'priority' => 32,
    ));
    
    // Текст помощи под формой предзаказа
    $wp_customize->add_setting('wolf_preorder_help_text', array(
        'default' => 'Если у вас возникли проблемы с оформлением предзаказа или вопросы, то можете обратиться к нам за помощью, стая никогда не отвернется от сородича, АУУУУУУУУУУФФ',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('wolf_preorder_help_text', array(
        'label' => __('Текст помощи под формой предзаказа', 'wolf-theme'),
        'section' => 'wolf_preorder',
        'type' => 'textarea',
    ));
    
    // === Секция: SEO настройки ===
    $wp_customize->add_section('wolf_seo', array(
        'title' => __('SEO настройки', 'wolf-theme'),
        'priority' => 29,
    ));
    
    // Мета-описание для главной страницы
    $wp_customize->add_setting('wolf_homepage_description', array(
        'default' => 'WOLF - Narrative Drama Game от студии HotKeysGames. Погрузитесь в мрачный и пронзительный литературный мир.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('wolf_homepage_description', array(
        'label' => __('Мета-описание главной страницы', 'wolf-theme'),
        'section' => 'wolf_seo',
        'type' => 'textarea',
        'description' => __('Рекомендуется: 150-160 символов', 'wolf-theme'),
    ));
    
    // === Секция: Изображения ===
    $wp_customize->add_section('wolf_images', array(
        'title' => __('Изображения', 'wolf-theme'),
        'priority' => 35,
    ));
    
    // Логотип игры (header)
    $wp_customize->add_setting('wolf_logo_game', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_logo_game', array(
        'label' => __('Логотип игры (в шапке)', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Загрузите логотип игры для отображения в шапке сайта', 'wolf-theme'),
    )));
    
    // Логотип компании (footer)
    $wp_customize->add_setting('wolf_logo_company', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_logo_company', array(
        'label' => __('Логотип компании (в подвале)', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Загрузите логотип компании для отображения в подвале сайта', 'wolf-theme'),
    )));
    
    // Маленький волк (для мобильных)
    $wp_customize->add_setting('wolf_image_small_wolf', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_small_wolf', array(
        'label' => __('Маленький волк (для мобильных экранов)', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Изображение маленького волка над надписью WOLF на мобильных устройствах', 'wolf-theme'),
    )));
    
    // Большой волк (для десктопа)
    $wp_customize->add_setting('wolf_image_large_wolf', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_large_wolf', array(
        'label' => __('Большой волк (для десктопа)', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Изображение большого волка по бокам от кнопки предзаказа на больших экранах', 'wolf-theme'),
    )));
    
    // Картина 1 (О игре - большие экраны)
    $wp_customize->add_setting('wolf_image_about_1', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_about_1', array(
        'label' => __('Картина 1 (секция "О игре")', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Первая картина в секции "О игре" для больших экранов', 'wolf-theme'),
    )));
    
    // Картина 2 (О игре - большие экраны)
    $wp_customize->add_setting('wolf_image_about_2', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_about_2', array(
        'label' => __('Картина 2 (секция "О игре")', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Вторая картина в секции "О игре" для больших экранов', 'wolf-theme'),
    )));
    
    // Картина 3 (О игре - большие экраны)
    $wp_customize->add_setting('wolf_image_about_3', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_about_3', array(
        'label' => __('Картина 3 (секция "О игре")', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Третья картина в секции "О игре" для больших экранов', 'wolf-theme'),
    )));
    
    // Изображение волков (О игре - снизу)
    $wp_customize->add_setting('wolf_image_about_wolves', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_image_about_wolves', array(
        'label' => __('Изображение волков (секция "О игре")', 'wolf-theme'),
        'section' => 'wolf_images',
        'mime_type' => 'image',
        'description' => __('Большое изображение волков внизу секции "О игре"', 'wolf-theme'),
    )));
    
    // === Секция: Галерея ===
    $wp_customize->add_section('wolf_gallery', array(
        'title' => __('Галерея', 'wolf-theme'),
        'priority' => 36,
    ));
    
    // Галерея - до 10 изображений
    for ($i = 1; $i <= 10; $i++) {
        $wp_customize->add_setting('wolf_gallery_image_' . $i, array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_gallery_image_' . $i, array(
            'label' => sprintf(__('Изображение галереи %d', 'wolf-theme'), $i),
            'section' => 'wolf_gallery',
            'mime_type' => 'image',
            'description' => sprintf(__('Загрузите изображение %d для галереи', 'wolf-theme'), $i),
        )));
    }
    
    // === Секция: Команда ===
    $wp_customize->add_section('wolf_team', array(
        'title' => __('Команда', 'wolf-theme'),
        'priority' => 37,
    ));
    
    // Участники команды - до 8 участников
    $team_members_default = array(
        'Анна "NOVIK"',
        'Алексей "BLACKBR"',
        'Ирина "LOTTABLE"',
        'Елизавета "HAKU"',
        'Александр "X_9"',
        'Вячеслав "STEP"',
        'Роман "RICT"',
        'Анна "LUKA"',
    );
    
    for ($i = 1; $i <= 8; $i++) {
        $member_name = isset($team_members_default[$i - 1]) ? $team_members_default[$i - 1] : sprintf(__('Участник %d', 'wolf-theme'), $i);
        
        // Фото участника
        $wp_customize->add_setting('wolf_team_member_photo_' . $i, array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_team_member_photo_' . $i, array(
            'label' => sprintf(__('%s - Фото', 'wolf-theme'), $member_name),
            'section' => 'wolf_team',
            'mime_type' => 'image',
            'description' => sprintf(__('Загрузите фото участника %d', 'wolf-theme'), $i),
        )));
        
        // Иконка участника
        $wp_customize->add_setting('wolf_team_member_icon_' . $i, array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wolf_team_member_icon_' . $i, array(
            'label' => sprintf(__('%s - Иконка', 'wolf-theme'), $member_name),
            'section' => 'wolf_team',
            'mime_type' => 'image',
            'description' => sprintf(__('Загрузите иконку участника %d (рекомендуется SVG)', 'wolf-theme'), $i),
        )));
    }
}
add_action('customize_register', 'wolf_theme_customize_register');

/**
 * Функция для получения настроек темы с fallback значением
 */
function wolf_get_setting($setting_name, $default = '') {
    $value = get_theme_mod($setting_name, $default);
    return !empty($value) ? $value : $default;
}

/**
 * Функция для получения URL изображения из настроек Customizer
 * Если изображение загружено через Customizer, возвращает его URL
 * Иначе возвращает путь к изображению по умолчанию
 */
function wolf_get_image_url($setting_name, $default_path = '') {
    $image_id = get_theme_mod($setting_name, '');
    
    if (!empty($image_id)) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    
    // Если изображение не загружено через Customizer, используем путь по умолчанию
    if (!empty($default_path)) {
        return get_template_directory_uri() . '/' . $default_path;
    }
    
    return '';
}

/**
 * Функция для получения изображения с alt текстом
 */
function wolf_get_image($setting_name, $default_path = '', $alt = '', $class = 'img-fluid') {
    $image_url = wolf_get_image_url($setting_name, $default_path);
    
    if (empty($image_url)) {
        return '';
    }
    
    $alt_attr = !empty($alt) ? esc_attr($alt) : '';
    $class_attr = !empty($class) ? esc_attr($class) : '';
    
    return '<img src="' . esc_url($image_url) . '" alt="' . $alt_attr . '" class="' . $class_attr . '">';
}

