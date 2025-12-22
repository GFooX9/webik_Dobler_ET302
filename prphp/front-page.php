<?php
/**
 * Template Name: Front Page
 * Главная страница сайта
 *
 * @package АНИЧ_Theme
 */

get_header();

// Поддержка редактирования контента главной страницы через WYSIWYG редактор
$page_content = '';
if (have_posts()) :
    while (have_posts()) : the_post();
        $page_content = apply_filters('the_content', get_the_content());
    endwhile;
endif;

// Выводим контент из редактора, если он есть
if (!empty($page_content)) {
    echo '<div class="container py-5">';
    echo $page_content;
    echo '</div>';
}
?>

    <!-- Главный баннер -->
    <header class="main-banner" style="background-image: url('<?php echo esc_url(anich_get_image_url('anich_banner_image', 'images/big_logo.jpeg')); ?>');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 text-white mb-4"><?php echo esc_html(anich_get_setting('anich_banner_title', 'Ассоциация Настольных Игр Челябинска')); ?></h1>
                    <p class="lead text-white mb-4"><?php echo esc_html(anich_get_setting('anich_banner_subtitle', 'Сообщество любителей настольных игр в Челябинске')); ?></p>
                    <a href="#events" class="btn btn-primary btn-lg"><?php echo esc_html(anich_get_setting('anich_banner_button', 'Ближайшие мероприятия')); ?></a>
                </div>
            </div>
        </div>
    </header>

    <!-- О нас -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title mb-4">Добро пожаловать в мир настольных игр!</h2>
                    <p class="lead"><?php echo wp_kses_post(anich_get_setting('anich_about_text_1', 'Настольные игры – явление, популярность которого набирает обороты с каждым днем.')); ?></p>
                    <p><?php echo wp_kses_post(anich_get_setting('anich_about_text_2', 'Мы проводим собственные игротеки, на которых представлены игры разных направленностей на любой вкус: квестовые, словесные, на реакцию и т. д. Также любой желающий может принести что-то свое, всегда есть люди, готовые помочь новичкам в освоении правил.')); ?></p>
                    <p><?php echo wp_kses_post(anich_get_setting('anich_about_text_3', 'Здесь вы найдёте близких по духу людей и просто сможете провести вечер в уютной атмосфере, поэтому берите в охапку друга, немного вкусняшек к чаю, чтобы проведенное время было максимально чудесным, свой позитивный настрой, и да начнется игра!')); ?></p>
                </div>
                <div class="col-lg-6">
                    <?php echo anich_get_image('anich_about_image', 'images/big_logo.jpeg', 'Логотип АНИЧ', 'img-fluid rounded shadow game-image'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Мероприятия -->
    <section id="events" class="py-5 events-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">Ближайшие мероприятия</h2>
            
            <div class="row">
                <?php for ($i = 1; $i <= 2; $i++) : 
                    $event_title = anich_get_setting('anich_event_' . $i . '_title', $i == 1 ? 'Турнир по "Воинам Сакуры"' : 'Тематическая игротека');
                    $event_place = anich_get_setting('anich_event_' . $i . '_place', $i == 1 ? 'ул. Братьев Кашириных 129' : 'Студенческий центр ЮУрГУ - пр-кт Ленина 80');
                    $event_date = anich_get_setting('anich_event_' . $i . '_date', $i == 1 ? '16 ноября' : '1 ноября');
                    $event_time = anich_get_setting('anich_event_' . $i . '_time', $i == 1 ? '12:30' : '13:40 - 19:40');
                    $event_link = anich_get_setting('anich_event_' . $i . '_link', $i == 1 ? 'https://vk.com/wall-80512985_2142' : 'https://vk.com/wall-80512985_2137');
                    $event_image = anich_get_image_url('anich_event_' . $i . '_image', $i == 1 ? 'images/sacura.jpeg' : 'images/horror.jpeg');
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($event_image) : ?>
                            <img src="<?php echo esc_url($event_image); ?>" class="card-img-top event-image" alt="<?php echo esc_attr($event_title); ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title"><?php echo esc_html($event_title); ?></h3>
                            <p class="card-text">
                                <strong>Место:</strong> <?php echo esc_html($event_place); ?><br>
                                <strong>Дата:</strong> <?php echo esc_html($event_date); ?><br>
                                <strong>Время:</strong> <?php echo esc_html($event_time); ?>
                            </p>
                            <a href="<?php echo esc_url($event_link); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-event">Записаться</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Популярные игры -->
    <section id="games" class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">Популярные игры</h2>
            
            <div class="row">
                <?php
                $game_images_default = array('uno', 'star', 'bang', 'imag', 'unm', 'dnd');
                $game_names_default = array('Uno', 'Звездные империи', 'Бэнг!', 'Имаджинариум', 'Unmatched', 'DnD');
                $game_descs_default = array(
                    'Одна из самых популярных но при этом простых в правилах игр, и не нуждается в представлении. Игра нравится людям всех возрастов. Игра быстрая и веселая.',
                    'В игре вам нужно создать собственный звездный флот, чтобы сразить противников. Игра не долгая, но потребует обдумывания решений о покупке того или иного космического корабля в свою флотилию.',
                    'Игра про перестрелку между шерифом и бандитами. Хоть и шериф имеет помощников, столу известна только роль шерифа. Игра совмещает карточное сражение и классическую Мафию.',
                    'Игра обрадует людей, которым не нравятся игры с математикой. Ведущему нужно описать изображение с запутанным сюжетом, а другие игроки под это описание предложат свое изображение.',
                    'Игра-карточное сражение. Выберете персонажа из Легенд, Мифов и Рассказов, и сразитесь с другими игроками. Тактика, знание сильных и слабых сторон персонажа - ключ к победе.',
                    'На весь мир известная НРИ. Игра имеет наиболее простые правила из всех НРИ. Играйте с друзьями, погружайтесь в Героическое Фэнтэзи. Вам понадобится DM - рассказчик, управляющий миром.',
                );
                
                for ($i = 1; $i <= 6; $i++) :
                    $game_name = anich_get_setting('anich_game_' . $i . '_name', $game_names_default[$i - 1]);
                    $game_desc = anich_get_setting('anich_game_' . $i . '_desc', $game_descs_default[$i - 1]);
                    $game_image = anich_get_image_url('anich_game_' . $i . '_image', 'images/' . $game_images_default[$i - 1] . ($i == 6 ? '.png' : '.jpeg'));
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($game_image) : ?>
                            <img src="<?php echo esc_url($game_image); ?>" class="card-img-top game-image" alt="<?php echo esc_attr($game_name); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo esc_html($game_name); ?></h3>
                            <p class="card-text"><?php echo wp_kses_post($game_desc); ?></p>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Фото мероприятий -->
    <section id="gallery" class="py-5 events-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">Фото мероприятий</h2>
            
            <div class="row">
                <?php for ($i = 1; $i <= 3; $i++) : 
                    $gallery_image = anich_get_image_url('anich_gallery_image_' . $i, 'images/photo' . $i . '.jpeg');
                ?>
                <div class="col-md-4 mb-4">
                    <?php if ($gallery_image) : ?>
                        <img src="<?php echo esc_url($gallery_image); ?>" class="img-fluid rounded shadow gallery-image" alt="Фото мероприятия <?php echo $i; ?>">
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

<?php get_footer(); ?>

