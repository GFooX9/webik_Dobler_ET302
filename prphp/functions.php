<?php
/**
 * АНИЧ Theme Functions
 *
 * @package АНИЧ_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Регистрация стилей и скриптов темы
 */
function anich_theme_enqueue_scripts() {
    // Регистрация стилей
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css', array(), '5.3.0-alpha1');
    wp_enqueue_style('font-awesome', 'https://kit.fontawesome.com/a076d05399.js', array(), '1.0');
    wp_enqueue_style('motion-ui', 'https://cdnjs.cloudflare.com/ajax/libs/motion-ui/2.0.3/motion-ui.min.css', array(), '2.0.3');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@400;600;700&family=Neucha&family=Play:wght@400;700&display=swap', array(), null);
    wp_enqueue_style('anich-theme-style', get_stylesheet_uri(), array('bootstrap-css'), '1.0');
    
    // Регистрация скриптов
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array(), '5.3.0-alpha1', true);
    wp_enqueue_script('motion-ui-js', 'https://cdnjs.cloudflare.com/ajax/libs/motion-ui/2.0.3/motion-ui.min.js', array(), '2.0.3', true);
    
    // Регистрация основного скрипта темы
    wp_enqueue_script('anich-theme-script', get_template_directory_uri() . '/script.js', array('bootstrap-js'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'anich_theme_enqueue_scripts');

/**
 * Поддержка функций темы
 */
function anich_theme_setup() {
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
    
    // Поддержка WYSIWYG редактора
    add_theme_support('editor-styles');
    add_editor_style('style.css');
    
    // Поддержка широкого и полного выравнивания контента
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'anich_theme_setup');

/**
 * Регистрация меню навигации
 */
function anich_theme_menus() {
    register_nav_menus(array(
        'primary' => __('Основное меню', 'anich-theme'),
    ));
}
add_action('init', 'anich_theme_menus');

/**
 * Кастомный Walker для меню навигации с поддержкой классов Bootstrap
 */
class Anich_Nav_Walker extends Walker_Nav_Menu {
    
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
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $link_classes = array('nav-link');
        $link_class = ! empty($link_classes) ? ' class="' . esc_attr(join(' ', $link_classes)) . '"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . $link_class .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
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
function anich_theme_add_editor_support() {
    add_post_type_support('page', 'editor');
    add_post_type_support('post', 'editor');
}
add_action('init', 'anich_theme_add_editor_support');

/**
 * Fallback меню, если меню не создано в админке
 */
function anich_theme_fallback_menu() {
    ?>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#about">О нас</a></li>
        <li class="nav-item"><a class="nav-link" href="#events">Мероприятия</a></li>
        <li class="nav-item"><a class="nav-link" href="#games">Игры</a></li>
        <li class="nav-item"><a class="nav-link" href="#gallery">Фото</a></li>
        <li class="nav-item"><a class="nav-link" href="#contacts">Контакты</a></li>
    </ul>
    <?php
}

// ===== НАСТРОЙКИ ТЕМЫ ДЛЯ РЕДАКТИРУЕМОГО КОНТЕНТА (Customizer API) =====

/**
 * Регистрация настроек темы через Customizer API
 */
function anich_theme_customize_register($wp_customize) {
    
    // === Секция: Контактная информация ===
    $wp_customize->add_section('anich_contacts', array(
        'title' => __('Контактная информация', 'anich-theme'),
        'priority' => 30,
    ));
    
    // Телефон
    $wp_customize->add_setting('anich_phone', array(
        'default' => '8-(000)-000-00-00',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('anich_phone', array(
        'label' => __('Телефон', 'anich-theme'),
        'section' => 'anich_contacts',
        'type' => 'text',
    ));
    
    // Telegram ссылка
    $wp_customize->add_setting('anich_telegram_url', array(
        'default' => 'https://t.me/ani4_boardgame_nri_mafia',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('anich_telegram_url', array(
        'label' => __('Ссылка на Telegram', 'anich-theme'),
        'section' => 'anich_contacts',
        'type' => 'url',
    ));
    
    // VK ссылка
    $wp_customize->add_setting('anich_vk_url', array(
        'default' => 'https://vk.com/geek_cult_boardgames',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('anich_vk_url', array(
        'label' => __('Ссылка на VK', 'anich-theme'),
        'section' => 'anich_contacts',
        'type' => 'url',
    ));
    
    // === Секция: Тексты секций ===
    $wp_customize->add_section('anich_sections', array(
        'title' => __('Тексты секций', 'anich-theme'),
        'priority' => 31,
    ));
    
    // Заголовок главного баннера
    $wp_customize->add_setting('anich_banner_title', array(
        'default' => 'Ассоциация Настольных Игр Челябинска',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('anich_banner_title', array(
        'label' => __('Заголовок главного баннера', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'text',
    ));
    
    // Подзаголовок главного баннера
    $wp_customize->add_setting('anich_banner_subtitle', array(
        'default' => 'Сообщество любителей настольных игр в Челябинске',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('anich_banner_subtitle', array(
        'label' => __('Подзаголовок главного баннера', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'text',
    ));
    
    // Текст кнопки баннера
    $wp_customize->add_setting('anich_banner_button', array(
        'default' => 'Ближайшие мероприятия',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('anich_banner_button', array(
        'label' => __('Текст кнопки баннера', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'text',
    ));
    
    // Текст секции "О нас" - абзац 1
    $wp_customize->add_setting('anich_about_text_1', array(
        'default' => 'Настольные игры – явление, популярность которого набирает обороты с каждым днем.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('anich_about_text_1', array(
        'label' => __('О нас - Абзац 1', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'textarea',
    ));
    
    // Текст секции "О нас" - абзац 2
    $wp_customize->add_setting('anich_about_text_2', array(
        'default' => 'Мы проводим собственные игротеки, на которых представлены игры разных направленностей на любой вкус: квестовые, словесные, на реакцию и т. д. Также любой желающий может принести что-то свое, всегда есть люди, готовые помочь новичкам в освоении правил.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('anich_about_text_2', array(
        'label' => __('О нас - Абзац 2', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'textarea',
    ));
    
    // Текст секции "О нас" - абзац 3
    $wp_customize->add_setting('anich_about_text_3', array(
        'default' => 'Здесь вы найдёте близких по духу людей и просто сможете провести вечер в уютной атмосфере, поэтому берите в охапку друга, немного вкусняшек к чаю, чтобы проведенное время было максимально чудесным, свой позитивный настрой, и да начнется игра!',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('anich_about_text_3', array(
        'label' => __('О нас - Абзац 3', 'anich-theme'),
        'section' => 'anich_sections',
        'type' => 'textarea',
    ));
    
    // === Секция: Мероприятия ===
    $wp_customize->add_section('anich_events', array(
        'title' => __('Мероприятия', 'anich-theme'),
        'priority' => 32,
    ));
    
    // Мероприятие 1
    for ($i = 1; $i <= 2; $i++) {
        $wp_customize->add_setting('anich_event_' . $i . '_title', array(
            'default' => $i == 1 ? 'Турнир по "Воинам Сакуры"' : 'Тематическая игротека',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('anich_event_' . $i . '_title', array(
            'label' => sprintf(__('Мероприятие %d - Название', 'anich-theme'), $i),
            'section' => 'anich_events',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('anich_event_' . $i . '_place', array(
            'default' => $i == 1 ? 'ул. Братьев Кашириных 129' : 'Студенческий центр ЮУрГУ - пр-кт Ленина 80',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('anich_event_' . $i . '_place', array(
            'label' => sprintf(__('Мероприятие %d - Место', 'anich-theme'), $i),
            'section' => 'anich_events',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('anich_event_' . $i . '_date', array(
            'default' => $i == 1 ? '16 ноября' : '1 ноября',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('anich_event_' . $i . '_date', array(
            'label' => sprintf(__('Мероприятие %d - Дата', 'anich-theme'), $i),
            'section' => 'anich_events',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('anich_event_' . $i . '_time', array(
            'default' => $i == 1 ? '12:30' : '13:40 - 19:40',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('anich_event_' . $i . '_time', array(
            'label' => sprintf(__('Мероприятие %d - Время', 'anich-theme'), $i),
            'section' => 'anich_events',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('anich_event_' . $i . '_link', array(
            'default' => $i == 1 ? 'https://vk.com/wall-80512985_2142' : 'https://vk.com/wall-80512985_2137',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('anich_event_' . $i . '_link', array(
            'label' => sprintf(__('Мероприятие %d - Ссылка', 'anich-theme'), $i),
            'section' => 'anich_events',
            'type' => 'url',
        ));
    }
    
    // === Секция: Игры ===
    $wp_customize->add_section('anich_games', array(
        'title' => __('Популярные игры', 'anich-theme'),
        'priority' => 33,
    ));
    
    $games_default = array(
        'Uno' => 'Одна из самых популярных но при этом простых в правилах игр, и не нуждается в представлении. Игра нравится людям всех возрастов. Игра быстрая и веселая.',
        'Звездные империи' => 'В игре вам нужно создать собственный звездный флот, чтобы сразить противников. Игра не долгая, но потребует обдумывания решений о покупке того или иного космического корабля в свою флотилию.',
        'Бэнг!' => 'Игра про перестрелку между шерифом и бандитами. Хоть и шериф имеет помощников, столу известна только роль шерифа. Игра совмещает карточное сражение и классическую Мафию.',
        'Имаджинариум' => 'Игра обрадует людей, которым не нравятся игры с математикой. Ведущему нужно описать изображение с запутанным сюжетом, а другие игроки под это описание предложат свое изображение.',
        'Unmatched' => 'Игра-карточное сражение. Выберете персонажа из Легенд, Мифов и Рассказов, и сразитесь с другими игроками. Тактика, знание сильных и слабых сторон персонажа - ключ к победе.',
        'DnD' => 'На весь мир известная НРИ. Игра имеет наиболее простые правила из всех НРИ. Играйте с друзьями, погружайтесь в Героическое Фэнтэзи. Вам понадобится DM - рассказчик, управляющий миром.',
    );
    
    $i = 1;
    foreach ($games_default as $game_name => $game_desc) {
        $wp_customize->add_setting('anich_game_' . $i . '_name', array(
            'default' => $game_name,
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('anich_game_' . $i . '_name', array(
            'label' => sprintf(__('Игра %d - Название', 'anich-theme'), $i),
            'section' => 'anich_games',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('anich_game_' . $i . '_desc', array(
            'default' => $game_desc,
            'sanitize_callback' => 'wp_kses_post',
        ));
        $wp_customize->add_control('anich_game_' . $i . '_desc', array(
            'label' => sprintf(__('Игра %d - Описание', 'anich-theme'), $i),
            'section' => 'anich_games',
            'type' => 'textarea',
        ));
        $i++;
    }
    
    // === Секция: Изображения ===
    $wp_customize->add_section('anich_images', array(
        'title' => __('Изображения', 'anich-theme'),
        'priority' => 35,
    ));
    
    // Главный баннер
    $wp_customize->add_setting('anich_banner_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'anich_banner_image', array(
        'label' => __('Изображение главного баннера', 'anich-theme'),
        'section' => 'anich_images',
        'mime_type' => 'image',
    )));
    
    // Изображение "О нас"
    $wp_customize->add_setting('anich_about_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'anich_about_image', array(
        'label' => __('Изображение секции "О нас"', 'anich-theme'),
        'section' => 'anich_images',
        'mime_type' => 'image',
    )));
    
    // Изображения мероприятий
    for ($i = 1; $i <= 2; $i++) {
        $wp_customize->add_setting('anich_event_' . $i . '_image', array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'anich_event_' . $i . '_image', array(
            'label' => sprintf(__('Изображение мероприятия %d', 'anich-theme'), $i),
            'section' => 'anich_images',
            'mime_type' => 'image',
        )));
    }
    
    // Изображения игр
    $game_images = array('uno', 'star', 'bang', 'imag', 'unm', 'dnd');
    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting('anich_game_' . $i . '_image', array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'anich_game_' . $i . '_image', array(
            'label' => sprintf(__('Изображение игры %d', 'anich-theme'), $i),
            'section' => 'anich_images',
            'mime_type' => 'image',
        )));
    }
    
    // Изображения галереи
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting('anich_gallery_image_' . $i, array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'anich_gallery_image_' . $i, array(
            'label' => sprintf(__('Изображение галереи %d', 'anich-theme'), $i),
            'section' => 'anich_images',
            'mime_type' => 'image',
        )));
    }
    
    // === Секция: SEO настройки ===
    $wp_customize->add_section('anich_seo', array(
        'title' => __('SEO настройки', 'anich-theme'),
        'priority' => 29,
    ));
    
    $wp_customize->add_setting('anich_homepage_description', array(
        'default' => 'Ассоциация Настольных Игр Челябинска (АНИЧ) - проводим игротеки, турниры, знакомим с настольными играми. Присоединяйтесь к нашему сообществу!',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('anich_homepage_description', array(
        'label' => __('Мета-описание главной страницы', 'anich-theme'),
        'section' => 'anich_seo',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'anich_theme_customize_register');

/**
 * Функция для получения настроек темы с fallback значением
 */
function anich_get_setting($setting_name, $default = '') {
    $value = get_theme_mod($setting_name, $default);
    return !empty($value) ? $value : $default;
}

/**
 * Функция для получения URL изображения из настроек Customizer
 */
function anich_get_image_url($setting_name, $default_path = '') {
    $image_id = get_theme_mod($setting_name, '');
    
    if (!empty($image_id)) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        if ($image_url) {
            return $image_url;
        }
    }
    
    if (!empty($default_path)) {
        return get_template_directory_uri() . '/' . $default_path;
    }
    
    return '';
}

/**
 * Функция для получения изображения с alt текстом
 */
function anich_get_image($setting_name, $default_path = '', $alt = '', $class = 'img-fluid') {
    $image_url = anich_get_image_url($setting_name, $default_path);
    
    if (empty($image_url)) {
        return '';
    }
    
    $alt_attr = !empty($alt) ? esc_attr($alt) : '';
    $class_attr = !empty($class) ? esc_attr($class) : '';
    
    return '<img src="' . esc_url($image_url) . '" alt="' . $alt_attr . '" class="' . $class_attr . '">';
}

