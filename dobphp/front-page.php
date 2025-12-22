<?php
/**
 * Template Name: Front Page
 * Главная страница сайта
 *
 * @package WOLF_Theme
 */

get_header();

// Поддержка редактирования контента главной страницы через WYSIWYG редактор
// Если страница содержит контент в редакторе, он будет выведен перед статическим шаблоном
$page_content = '';
if (have_posts()) :
    while (have_posts()) : the_post();
        $page_content = apply_filters('the_content', get_the_content());
    endwhile;
endif;
?>

    <!-- Hero Section -->
    <header class="hero-section d-flex align-items-center justify-content-center text-center">
        <div class="container">
            <!-- Маленький волк для версий lg, md, sm, xs -->
            <div class="small-wolf-above-title d-block d-xl-none">
                <?php 
                $small_wolf_url = wolf_get_image_url('wolf_image_small_wolf', 'Materials/Window hero/Small Wolf.svg');
                if ($small_wolf_url) : ?>
                    <img src="<?php echo esc_url($small_wolf_url); ?>" alt="Small Wolf" class="small-wolf-icon">
                <?php endif; ?>
            </div>
            <h1 class="main-title">WOLF</h1>
            
            <div class="row align-items-center justify-content-center wolf-composition">
                <!-- Два больших волка только для xxl и xl -->
                <div class="col-3 d-none d-xl-block">
                    <?php 
                    $large_wolf_url = wolf_get_image_url('wolf_image_large_wolf', 'Materials/Window hero/wolf.svg');
                    if ($large_wolf_url) : ?>
                        <img src="<?php echo esc_url($large_wolf_url); ?>" alt="Wolf Left" class="img-fluid wolf-silhouette">
                    <?php endif; ?>
                </div>
                
                <div class="col-12 col-xl-4">
                    <button class="btn btn-main-cta" onclick="document.getElementById('preorder').scrollIntoView({behavior: 'smooth'})">
                        <?php echo wp_kses_post(wolf_get_setting('wolf_preorder_button_text', 'ОФОРМИТЬ<br>ПРЕДЗАКАЗ')); ?>
                    </button>
                </div>

                <div class="col-3 d-none d-xl-block">
                    <?php 
                    $large_wolf_url = wolf_get_image_url('wolf_image_large_wolf', 'Materials/Window hero/wolf.svg');
                    if ($large_wolf_url) : ?>
                        <img src="<?php echo esc_url($large_wolf_url); ?>" alt="Wolf Right" class="img-fluid wolf-silhouette flip-h">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-badge">О ИГРЕ</div>
            </div>
            
            <!-- Вариант 1: Для больших мониторов (xxl, xl) -->
            <div class="d-none d-xl-block">
                <!-- Первый абзац: текст слева, картина справа -->
                <div class="row align-items-center mb-5">
                    <div class="col-xl-6">
                        <p class="story-text text-center">
                            <?php echo wp_kses_post(wolf_get_setting('wolf_about_text_1', 'Wolf — это повествовательная драма от студии HotKeysGames, которая переносит на игровой холст мрачный и пронзительный литературный мир. История игры рождается из страниц культовой серии книг «Unhappy stories» российского писателя Александра Доблера. Мы бережно сохранили уникальную атмосферу его прозы — гнетущее очарование юга Европы, психологическую глубину персонажей и философское осмысление хрупкости человеческих судеб.')); ?>
                        </p>
                    </div>
                    <div class="col-xl-6 text-center">
                        <?php 
                        $about_img_1_url = wolf_get_image_url('wolf_image_about_1', 'Materials/Block about/картина 1.jpg');
                        if ($about_img_1_url) : ?>
                            <img src="<?php echo esc_url($about_img_1_url); ?>" alt="Картина 1" class="img-fluid about-image">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Второй абзац: картина слева, текст справа -->
                <div class="row align-items-center mb-5">
                    <div class="col-xl-6 order-xl-2">
                        <p class="story-text text-center">
                            <?php echo wp_kses_post(wolf_get_setting('wolf_about_text_2', 'Действие разворачивается в вымышленной стране на юге Европы в середине XX века. Время, когда старый мир трещит по швам, а новый еще не родился. Здесь, под палящим солнцем и в тени старых вилл, начинается взросление юного героя. Его первые шаги во взрослую жизнь неожиданно становятся шагами в лабиринт прошлого — прошлого его родителей, полного болезненных тайн, невысказанных обид и решений, которые отзываются эхом спустя десятилетия.')); ?>
                        </p>
                    </div>
                    <div class="col-xl-6 order-xl-1 text-center">
                        <?php 
                        $about_img_2_url = wolf_get_image_url('wolf_image_about_2', 'Materials/Block about/Картина 2.jpg');
                        if ($about_img_2_url) : ?>
                            <img src="<?php echo esc_url($about_img_2_url); ?>" alt="Картина 2" class="img-fluid about-image">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Третий абзац: текст слева, картина справа -->
                <div class="row align-items-center mb-5">
                    <div class="col-xl-6">
                        <p class="story-text text-center">
                            <?php echo wp_kses_post(wolf_get_setting('wolf_about_text_3', 'Игрокам предстоит не просто пройти сюжет, а распутать сложнейший клубок из множества человеческих историй. Каждый новый знакомый, каждая найденная записка, каждый полунамёк в разговоре — это нить, которая может привести как к прозрению, так и к новой ловушке. Судьбы родителей, их любовь, предательство, надежды и страх сплетаются с собственной жизнью героя, заставляя его задавать главные вопросы: Кто мы — продолжатели судеб наших родителей или заложники их ошибок? Можно ли разорвать порочный круг, если его истоки скрыты во тьме прошлого?')); ?>
                        </p>
                    </div>
                    <div class="col-xl-6 text-center">
                        <?php 
                        $about_img_3_url = wolf_get_image_url('wolf_image_about_3', 'Materials/Block about/картина 3.jpg');
                        if ($about_img_3_url) : ?>
                            <img src="<?php echo esc_url($about_img_3_url); ?>" alt="Картина 3" class="img-fluid about-image">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Волки снизу -->
                <div class="row mt-5">
                    <div class="col-12">
                        <?php 
                        $wolves_url = wolf_get_image_url('wolf_image_about_wolves', 'Materials/Block about/волки.png');
                        if ($wolves_url) : ?>
                            <img src="<?php echo esc_url($wolves_url); ?>" alt="Волки" class="img-fluid about-wolves">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Вариант 2: Для ноутбуков и планшетов (lg, md) -->
            <div class="d-none d-lg-block d-xl-none">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-10">
                        <p class="story-text text-center">
                            <?php echo wp_kses_post(wolf_get_setting('wolf_about_text_small', 'Игра "Wolf" была создана компанией HotKeysGames по мотивам серии книг Unhappy stories, автором которой является российский писатель Доблер Александр. Игра рассказывает историю происходящую в вымышленной стране на юге Европы 20 века, где подросток начинает взрослую жизнь, которая тесно переплетается с прошлым его родителей. По ходу игры, с развитием сюжета игрокам предстоит распутать клубок, сплетенный из множества человеческих историй.')); ?>
                        </p>
                    </div>
                </div>

                <div class="row justify-content-center g-4 mt-4">
                    <div class="col-md-4">
                        <?php 
                        $about_img_1_url = wolf_get_image_url('wolf_image_about_1', 'Materials/Block about/картина 1.jpg');
                        if ($about_img_1_url) : ?>
                            <img src="<?php echo esc_url($about_img_1_url); ?>" alt="Картина 1" class="img-fluid about-image-small">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php 
                        $about_img_2_url = wolf_get_image_url('wolf_image_about_2', 'Materials/Block about/Картина 2.jpg');
                        if ($about_img_2_url) : ?>
                            <img src="<?php echo esc_url($about_img_2_url); ?>" alt="Картина 2" class="img-fluid about-image-small">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php 
                        $about_img_3_url = wolf_get_image_url('wolf_image_about_3', 'Materials/Block about/картина 3.jpg');
                        if ($about_img_3_url) : ?>
                            <img src="<?php echo esc_url($about_img_3_url); ?>" alt="Картина 3" class="img-fluid about-image-small">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Вариант 3: Для небольших планшетов и телефонов (xs, sm) -->
            <div class="d-block d-lg-none">
                <div class="row justify-content-center mb-4">
                    <div class="col-12">
                        <p class="story-text text-center">
                            <?php echo wp_kses_post(wolf_get_setting('wolf_about_text_small', 'Игра "Wolf" была создана компанией HotKeysGames по мотивам серии книг Unhappy stories, автором которой является российский писатель Доблер Александр. Игра рассказывает историю происходящую в вымышленной стране на юге Европы 20 века, где подросток начинает взрослую жизнь, которая тесно переплетается с прошлым его родителей. По ходу игры, с развитием сюжета игрокам предстоит распутать клубок, сплетенный из множества человеческих историй.')); ?>
                        </p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <?php 
                        $wolves_url = wolf_get_image_url('wolf_image_about_wolves', 'Materials/Block about/волки.png');
                        if ($wolves_url) : ?>
                            <img src="<?php echo esc_url($wolves_url); ?>" alt="Волки" class="img-fluid about-wolves">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery-section py-5">
        <div class="container text-center">
            <div class="section-badge mb-5">ГАЛЕРЕЯ</div>
            <!-- Текст для больших экранов (lg и выше) -->
            <p class="mb-5 section-desc d-none d-lg-block"><?php echo wp_kses_post(wolf_get_setting('wolf_gallery_text_large', 'Иногда стоит остановиться, чтобы увидеть всё великолепие этого мира. Мы представляем наброски из нашей галереи, которые в будущем будут реализованы. Здесь собраны все арты, концепты, персонажи и воспоминания, которые вам удалось открыть по ходу игры. Исследуйте разделы, чтобы увидеть детали мира, узнать больше о героях и пережить ключевые моменты истории снова. Некоторые элементы скрыты — чтобы их найти, понадобится внимание и смекалка. Собирайте коллекцию полностью!')); ?></p>
            <!-- Текст для маленьких экранов (меньше lg) -->
            <p class="mb-5 section-desc d-block d-lg-none"><?php echo wp_kses_post(wolf_get_setting('wolf_gallery_text_small', 'Иногда стоит остановиться, чтобы увидеть всё великолепие этого мира. Мы представляем наброски из нашей галереи, которые в будущем будут реализованы. Здесь собраны все арты, концепты, персонажи и воспоминания, которые вы откроете по ходу игры.')); ?></p>

            <div class="gallery-scroll-container">
                <div class="gallery-scroll">
                    <?php
                    // Получаем изображения из Customizer или используем значения по умолчанию
                    $gallery_images_default = array(
                        'Картина 1.jpg', 'Картина 2.jpg', 'Картина 3.jpg', 'Картина 4.jpg', 'Картина 5.jpg',
                        'Картина 6.jpg', 'Картина 7.jpg', 'Картина 8.jpg', 'Картина 9.jpg', 'Картина 10.jpg'
                    );
                    
                    for ($i = 1; $i <= 10; $i++) {
                        $image_id = get_theme_mod('wolf_gallery_image_' . $i, '');
                        $image_url = '';
                        
                        if (!empty($image_id)) {
                            $image_url = wp_get_attachment_image_url($image_id, 'full');
                        }
                        
                        // Если изображение не загружено через Customizer, используем значение по умолчанию
                        if (empty($image_url) && isset($gallery_images_default[$i - 1])) {
                            $image_url = get_template_directory_uri() . '/Materials/Gallery/' . $gallery_images_default[$i - 1];
                        }
                        
                        // Показываем только если есть изображение
                        if (!empty($image_url)) {
                            echo '<div class="gallery-card">';
                            echo '<img src="' . esc_url($image_url) . '" alt="Картина ' . $i . '" class="img-fluid">';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section py-5">
        <div class="container text-center">
            <div class="section-badge mb-5">КОМАНДА</div>
            <p class="mb-5 section-desc"><?php echo wp_kses_post(wolf_get_setting('wolf_team_text', 'Создание игры — это история о том, как разные люди с разными навыками объединяются ради общей цели: подарить миру новые эмоции, новые миры и новые приключения. Команда — это и есть настоящая магия геймдева.')); ?></p>

            <div class="team-scroll-container">
                <div class="team-scroll">
                    <?php
                    $team_members = array(
                        array('name' => 'Анна "NOVIK"', 'role' => 'ВЕДУЩИЙ<br>ГЕЙМДИЗАЙНЕР', 'desc' => 'Создает различные модели, отвечает за персонажей', 'quote' => '«Сначала — силуэт. Если он читается, модель будет работать в любой игре»', 'avatar' => '1 Анна novik/анна novik.jpg', 'icon' => '1 Анна novik/ico novik.svg', 'class' => 'avatar-novik role-box-novik'),
                        array('name' => 'Алексей "BLACKBR"', 'role' => 'ПРОГРАММИСТ', 'desc' => 'Интегрирует модели, создает оформления, "кожа"', 'quote' => '«Производительность— это не оптимизация, это образ мышления»', 'avatar' => '2 Алексей blackbr/алексей blackbr.jpg', 'icon' => '2 Алексей blackbr/ico blackbr.svg', 'class' => ''),
                        array('name' => 'Ирина "LOTTABLE"', 'role' => 'PROJECT<br>MANAGER', 'desc' => 'Распределяет дедлайны работы, следит за продвижением работы', 'quote' => '«Я как пожарный, который бегает с канистрой бензина и огнетушителем одновременно»', 'avatar' => '3 Ирина lottablk/ирина lottablk.jpg', 'icon' => '3 Ирина lottablk/ico lottablk.svg', 'class' => 'avatar-lottablk role-box-lottablk'),
                        array('name' => 'Елизавета "HAKU"', 'role' => 'ИГРОВОЙ<br>СЦЕНАРИСТ', 'desc' => 'Планирует для вас игровой сценарий и окружение персонажей', 'quote' => '«Сегодня пишем "плохо".Завтра перепишем "хорошо".Главное — чтобы был каркас»', 'avatar' => '4 Елизавета haku/елизавета haku.jpg', 'icon' => '4 Елизавета haku/ico Haku.svg', 'class' => ''),
                        array('name' => 'Александр "X_9"', 'role' => 'TEAM LEADER', 'desc' => 'Пишет историю...Основатель компании HotKeysGames', 'quote' => '«Игрок — мой соавтор.Его любопытство — мой сюжет, а его решения — мои повороты»', 'avatar' => '5 Александр x_9/александр x_9.jpg', 'icon' => '5 Александр x_9/ico X_9.svg', 'class' => ''),
                        array('name' => 'Вячеслав "STEP"', 'role' => 'ПРОГРАММИСТ', 'desc' => 'Реализацует сцены и работает с движениями, "скелет"', 'quote' => '«Сильно связанный код пахнет. И пахнет не свежими булочками(»', 'avatar' => '6 Вячеслав step/вячеслав step.jpg', 'icon' => '6 Вячеслав step/ico step.svg', 'class' => 'avatar-step role-box-step'),
                        array('name' => 'Роман "RICT"', 'role' => 'ВЕДУЩИЙ<br>ПРОГРАММИСТ', 'desc' => 'Отвечает за работоспособность игры и людей)', 'quote' => '«Производительность — это не оптимизация, это образ мышления»', 'avatar' => '7 Роман rict/роман rict.jpg', 'icon' => '7 Роман rict/ico rict.svg', 'class' => 'avatar-rict role-box-rict'),
                        array('name' => 'Анна "LUKA"', 'role' => 'ГЕЙМДИЗАЙНЕР', 'desc' => 'Созданет различные модели, отвечает за интерьер', 'quote' => '«Я переводчик: превращаю концепт в живую, осязаемую вещь»', 'avatar' => '8 Анна luka/анна luka.jpg', 'icon' => '8 Анна luka/ico luka.svg', 'class' => 'avatar-luka role-box-luka'),
                    );
                    
                    foreach ($team_members as $index => $member) {
                        $member_num = $index + 1;
                        $avatar_class = strpos($member['class'], 'avatar-') !== false ? explode(' ', $member['class'])[0] : '';
                        $role_class = strpos($member['class'], 'role-box-') !== false ? explode(' ', $member['class'])[1] : '';
                        
                        // Получаем фото из Customizer или используем значение по умолчанию
                        $photo_id = get_theme_mod('wolf_team_member_photo_' . $member_num, '');
                        $photo_url = '';
                        if (!empty($photo_id)) {
                            $photo_url = wp_get_attachment_image_url($photo_id, 'full');
                        }
                        if (empty($photo_url)) {
                            $photo_url = get_template_directory_uri() . '/Materials/Team/' . $member['avatar'];
                        }
                        
                        // Получаем иконку из Customizer или используем значение по умолчанию
                        $icon_id = get_theme_mod('wolf_team_member_icon_' . $member_num, '');
                        $icon_url = '';
                        if (!empty($icon_id)) {
                            $icon_url = wp_get_attachment_image_url($icon_id, 'full');
                        }
                        if (empty($icon_url)) {
                            $icon_url = get_template_directory_uri() . '/Materials/Team/' . $member['icon'];
                        }
                        ?>
                        <div class="team-member-card">
                            <div class="avatar-wrapper <?php echo esc_attr($avatar_class); ?>">
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="avatar-rounded-square img-fluid">
                            </div>
                            <div class="role-box <?php echo esc_attr($role_class); ?>">
                                <div class="role-title"><?php echo $member['role']; ?></div>
                                <h4 class="member-name"><?php echo esc_html($member['name']); ?></h4>
                                <p class="role-desc"><?php echo esc_html($member['desc']); ?></p>
                                <p class="quote"><?php echo esc_html($member['quote']); ?></p>
                                <div class="icon-bottom">
                                    <?php if (!empty($icon_url)) : ?>
                                        <img src="<?php echo esc_url($icon_url); ?>" alt="Icon" class="team-icon">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Preorder Form Section -->
    <section id="preorder" class="preorder-section py-5">
        <div class="container">
            <div class="text-center mb-4">
                <div class="section-badge dark-badge">ФОРМА ПРЕДЗАКАЗА</div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="form-container">
                        <form id="orderForm">
                            <div class="mb-3 input-group-custom">
                                <span class="input-icon"><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Введите ваше ФИО:" required>
                                <span class="input-clear">&times;</span>
                            </div>

                            <div class="mb-3 input-group-custom">
                                <span class="input-icon"><i class="fa-solid fa-at"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Введите вашу почту:" required>
                                <span class="input-clear">&times;</span>
                            </div>

                            <div class="mb-3">
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="fa-solid fa-check"></i></span>
                                    <input type="email" id="emailConfirm" name="emailConfirm" class="form-control" placeholder="Подтвердите верность вашей почты:" required>
                                    <span class="input-clear">&times;</span>
                                </div>
                                <div class="invalid-feedback" style="display: none;">
                                    Почты не совпадают
                                </div>
                            </div>

                            <!-- Captcha Area -->
                            <div class="captcha-area d-flex align-items-center justify-content-between mt-4">
                                <?php 
                                $small_wolf_url = wolf_get_image_url('wolf_image_small_wolf', 'Materials/Window hero/Small Wolf.svg');
                                if ($small_wolf_url) : ?>
                                    <img src="<?php echo esc_url($small_wolf_url); ?>" alt="Wolf" class="captcha-wolf-icon">
                                <?php endif; ?>
                                <div class="captcha-box text-center">
                                    <div class="captcha-img mb-2" style="background: #ddd; height: 40px; width: 100px; margin: 0 auto;"></div>
                                    <input type="text" class="form-control text-center" placeholder="Введите код" required>
                                </div>
                                <?php 
                                $small_wolf_url = wolf_get_image_url('wolf_image_small_wolf', 'Materials/Window hero/Small Wolf.svg');
                                if ($small_wolf_url) : ?>
                                    <img src="<?php echo esc_url($small_wolf_url); ?>" alt="Wolf" class="captcha-wolf-icon flip-horizontal">
                                <?php endif; ?>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-submit">ОТПРАВИТЬ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 footer-help-text">
                <small><?php echo wp_kses_post(wolf_get_setting('wolf_preorder_help_text', 'Если у вас возникли проблемы с оформлением предзаказа или вопросы, то можете обратиться к нам за помощью, стая никогда не отвернется от сородича, АУУУУУУУУУУФФ')); ?></small>
                <div class="mt-3">
                    <button class="btn btn-support-small" data-bs-toggle="modal" data-bs-target="#supportModal">ПОДДЕРЖКА</button>
                </div>
            </div>
        </div>
    </section>

<?php 
// Выводим контент из WYSIWYG редактора, если он есть
if (trim(strip_tags($page_content))) : ?>
    <div class="container page-wysiwyg-content my-5">
        <div class="row">
            <div class="col-12">
                <?php echo $page_content; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>

