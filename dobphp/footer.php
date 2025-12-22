    <!-- Footer -->
    <footer class="main-footer py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="logos mb-3 mb-md-0 d-flex align-items-center gap-3">
                <!-- Логотип компании -->
                <div class="hk-logo border-box">
                    <?php 
                    $company_logo_url = wolf_get_image_url('wolf_logo_company', 'Materials/Icons for futter and header/Logo company.svg');
                    if ($company_logo_url) : ?>
                        <img src="<?php echo esc_url($company_logo_url); ?>" alt="Логотип компании HotKeysGames">
                    <?php endif; ?>
                </div>
                <!-- Логотип игры -->
                <div class="footer-wolf-logo">
                    <?php 
                    $logo_url = wolf_get_image_url('wolf_logo_game', 'Materials/Icons for futter and header/Logo game.svg');
                    if ($logo_url) : ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Логотип игры WOLF">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="socials d-flex gap-3">
                <div class="about-circle">
                    <span>О НАС:</span>
                </div>
                <a href="<?php echo esc_url(wolf_get_setting('wolf_vk_url', '#')); ?>" class="social-circle" aria-label="VK" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for futter and header/Vk.svg" alt="VK">
                </a>
                <a href="<?php echo esc_url(wolf_get_setting('wolf_discord_url', '#')); ?>" class="social-circle" aria-label="Discord" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for futter and header/Discord.svg" alt="Discord">
                </a>
                <a href="<?php echo esc_url(wolf_get_setting('wolf_steam_url', '#')); ?>" class="social-circle" aria-label="Steam" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for futter and header/steam.svg" alt="Steam">
                </a>
                <a href="<?php echo esc_url(wolf_get_setting('wolf_facebook_url', '#')); ?>" class="social-circle" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for futter and header/facebook.svg" alt="Facebook">
                </a>
            </div>
        </div>
    </footer>

    <!-- Support Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content support-modal-content">
                <div class="modal-body p-4">
                    <form id="supportForm">
                        <div class="mb-3 input-group-custom">
                            <span class="input-icon"><i class="fa-regular fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Введите ваше ФИО:" required>
                            <span class="input-clear">&times;</span>
                        </div>
                        <div class="mb-3 input-group-custom">
                            <span class="input-icon"><i class="fa-solid fa-at"></i></span>
                            <input type="email" class="form-control" placeholder="Введите вашу почту:" required>
                            <span class="input-clear">&times;</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="mb-2">Опишите вашу проблему или задайте вопрос:</label>
                            <textarea class="form-control custom-textarea" rows="5" placeholder="Ваш текст" required></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-icon-round" data-bs-dismiss="modal">
                                <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for form/Undo.svg" alt="Назад" class="form-icon">
                            </button>
                            <button type="submit" class="btn btn-icon-round">
                                <img src="<?php echo get_template_directory_uri(); ?>/Materials/Icons for form/To send.svg" alt="Отправить" class="form-icon">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>

