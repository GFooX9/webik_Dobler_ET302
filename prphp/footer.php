    <!-- Футер -->
    <footer id="contacts" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="footer-title">АНИЧ</h3>
                    <p>Ассоциация Настольных Игр Челябинска</p>
                    <p>Присоединяйтесь к нашему сообществу!</p>
                </div>
                
                <div class="col-md-4 mb-4 mb-md-0">
                    <h4 class="footer-subtitle">Контакты</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-phone-alt me-2"></i>
                            Телефон: <?php echo esc_html(anich_get_setting('anich_phone', '8-(000)-000-00-00')); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fab fa-telegram me-2"></i>
                            Телеграм: <a href="<?php echo esc_url(anich_get_setting('anich_telegram_url', 'https://t.me/ani4_boardgame_nri_mafia')); ?>" target="_blank" rel="noopener noreferrer">@ani4_boardgame_nri_mafia</a>
                        </li>
                        <li class="mb-2">
                            <i class="fab fa-vk me-2"></i>
                            ВКонтакте: <a href="<?php echo esc_url(anich_get_setting('anich_vk_url', 'https://vk.com/geek_cult_boardgames')); ?>" target="_blank" rel="noopener noreferrer">geek_cult_boardgames</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <h4 class="footer-subtitle">Быстрые ссылки</h4>
                    <ul class="list-unstyled">
                        <li><a href="#about" class="footer-link">О нас</a></li>
                        <li><a href="#events" class="footer-link">Мероприятия</a></li>
                        <li><a href="#games" class="footer-link">Игры</a></li>
                        <li><a href="#gallery" class="footer-link">Фото</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> АНИЧ - Ассоциация Настольных Игр Челябинска. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>

