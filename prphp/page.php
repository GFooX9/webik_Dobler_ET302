<?php
/**
 * Шаблон страниц
 * Используется для отображения отдельных страниц с поддержкой WYSIWYG редактора
 *
 * @package АНИЧ_Theme
 */

get_header(); ?>

<?php
while (have_posts()) {
    the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="container py-5">
            <header class="entry-header mb-4">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php
                // Выводим контент страницы, отредактированный через WYSIWYG редактор
                the_content();
                
                // Добавляем пагинацию для длинных страниц
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Страницы:', 'anich-theme'),
                    'after'  => '</div>',
                ));
                ?>
            </div>
        </div>
    </article>
    <?php
}
?>

<?php get_footer(); ?>

