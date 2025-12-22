<?php
/**
 * Основной шаблон темы
 * Используется как fallback для всех страниц
 *
 * @package АНИЧ_Theme
 */

get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="container py-5">
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
        <?php
    }
} else {
    ?>
    <div class="container py-5">
        <p><?php esc_html_e('Контент не найден.', 'anich-theme'); ?></p>
    </div>
    <?php
}
?>

<?php get_footer(); ?>

