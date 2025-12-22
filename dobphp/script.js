document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Плавный скролл при клике на навигацию (если нужны кастомные эффекты)
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            // Пропускаем обработку для ссылок в мобильном меню (они обрабатываются отдельно)
            if (window.innerWidth <= 991 && this.closest('.navbar-collapse')) {
                return;
            }
            
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // 2. Очистка полей ввода по клику на крестик
    const clearButtons = document.querySelectorAll('.input-clear');
    clearButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const inputGroup = e.target.closest('.input-group-custom');
            if (inputGroup) {
                const input = inputGroup.querySelector('input');
                if (input) {
                    input.value = '';
                    input.focus();
                }
            }
        });
    });

    // 3. Обработка формы предзаказа (имитация)
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        const emailInput = document.getElementById('email');
        const emailConfirmInput = document.getElementById('emailConfirm');
        const emailConfirmContainer = emailConfirmInput?.closest('.mb-3');
        const emailConfirmFeedback = emailConfirmContainer?.querySelector('.invalid-feedback');
        
        // Функция проверки совпадения почт
        const validateEmailMatch = () => {
            if (emailInput && emailConfirmInput) {
                const email = emailInput.value.trim();
                const emailConfirm = emailConfirmInput.value.trim();
                
                if (emailConfirm && email !== emailConfirm) {
                    emailConfirmInput.setCustomValidity('Почты не совпадают');
                    if (emailConfirmFeedback) {
                        emailConfirmFeedback.style.display = 'block';
                    }
                    emailConfirmInput.classList.add('is-invalid');
                    return false;
                } else {
                    emailConfirmInput.setCustomValidity('');
                    if (emailConfirmFeedback) {
                        emailConfirmFeedback.style.display = 'none';
                    }
                    emailConfirmInput.classList.remove('is-invalid');
                    return true;
                }
            }
            return true;
        };
        
        // Проверка при изменении полей почты
        if (emailInput) {
            emailInput.addEventListener('input', validateEmailMatch);
        }
        if (emailConfirmInput) {
            emailConfirmInput.addEventListener('input', validateEmailMatch);
        }
        
        orderForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Проверка совпадения почт
            if (!validateEmailMatch()) {
                emailConfirmInput.focus();
                return;
            }
            
            // Проверка валидности формы
            if (!orderForm.checkValidity()) {
                orderForm.reportValidity();
                return;
            }
            
            const btn = orderForm.querySelector('.btn-submit');
            const originalText = btn.innerText;
            
            btn.innerText = 'ОТПРАВЛЕНО!';
            btn.classList.add('btn-success');
            btn.disabled = true;

            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove('btn-success');
                btn.disabled = false;
                orderForm.reset();
                // Сбрасываем кастомную валидацию
                if (emailConfirmInput) {
                    emailConfirmInput.setCustomValidity('');
                    emailConfirmInput.classList.remove('is-invalid');
                }
                if (emailConfirmFeedback) {
                    emailConfirmFeedback.style.display = 'none';
                }
                alert("Спасибо за предзаказ! (Демонстрация)");
            }, 2000);
        });
    }

    // 4. Обработка формы поддержки
    const supportForm = document.getElementById('supportForm');
    if (supportForm) {
        supportForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Проверка валидности формы
            if (!supportForm.checkValidity()) {
                supportForm.reportValidity();
                return;
            }
            
            const submitBtn = supportForm.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            const templateUri = typeof wolfTheme !== 'undefined' ? wolfTheme.templateUri : '';
            submitBtn.innerHTML = '<img src="' + templateUri + '/Materials/Icons for form/To send.svg" alt="Отправить" class="form-icon">';
            submitBtn.disabled = true;
            
            // Имитация отправки
            setTimeout(() => {
                alert("Спасибо за обращение! Мы свяжемся с вами в ближайшее время. (Демонстрация)");
                supportForm.reset();
                
                // Закрываем модальное окно
                const modal = bootstrap.Modal.getInstance(document.getElementById('supportModal'));
                if (modal) {
                    modal.hide();
                }
                
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            }, 1000);
        });
    }

    // UX Animation Placeholder: 
    // Здесь можно добавить Intersection Observer для анимации появления элементов при скролле.
    
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Добавить класс CSS для анимации (например, fade-in-up)
            }
        });
    }, observerOptions);

    // Пример добавления наблюдателя на карточки
    document.querySelectorAll('.team-member, .gallery-card').forEach(el => {
        // el.style.opacity = "0"; // Начальное состояние (лучше делать в CSS)
        // el.style.transition = "all 0.6s ease-out";
        observer.observe(el);
    });

    // 4. Drag-to-scroll для галереи
    const galleryScroll = document.querySelector('.gallery-scroll-container');
    if (galleryScroll) {
        let isDown = false;
        let startX;
        let scrollLeft;

        // Мышь
        galleryScroll.addEventListener('mousedown', (e) => {
            isDown = true;
            galleryScroll.style.cursor = 'grabbing';
            startX = e.pageX - galleryScroll.offsetLeft;
            scrollLeft = galleryScroll.scrollLeft;
        });

        galleryScroll.addEventListener('mouseleave', () => {
            isDown = false;
            galleryScroll.style.cursor = 'grab';
        });

        galleryScroll.addEventListener('mouseup', () => {
            isDown = false;
            galleryScroll.style.cursor = 'grab';
        });

        galleryScroll.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - galleryScroll.offsetLeft;
            const walk = (x - startX) * 2; // Скорость прокрутки
            galleryScroll.scrollLeft = scrollLeft - walk;
        });

        // Тач-устройства
        let touchStartX = 0;
        let touchScrollLeft = 0;

        galleryScroll.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].pageX - galleryScroll.offsetLeft;
            touchScrollLeft = galleryScroll.scrollLeft;
        });

        galleryScroll.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const x = e.touches[0].pageX - galleryScroll.offsetLeft;
            const walk = (x - touchStartX) * 2;
            galleryScroll.scrollLeft = touchScrollLeft - walk;
        });

        // Устанавливаем курсор по умолчанию
        galleryScroll.style.cursor = 'grab';
    }

    // 5. Drag-to-scroll для команды
    const teamScroll = document.querySelector('.team-scroll-container');
    if (teamScroll) {
        let isDown = false;
        let startX;
        let scrollLeft;

        // Мышь
        teamScroll.addEventListener('mousedown', (e) => {
            isDown = true;
            teamScroll.style.cursor = 'grabbing';
            startX = e.pageX - teamScroll.offsetLeft;
            scrollLeft = teamScroll.scrollLeft;
        });

        teamScroll.addEventListener('mouseleave', () => {
            isDown = false;
            teamScroll.style.cursor = 'grab';
        });

        teamScroll.addEventListener('mouseup', () => {
            isDown = false;
            teamScroll.style.cursor = 'grab';
        });

        teamScroll.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - teamScroll.offsetLeft;
            const walk = (x - startX) * 2; // Скорость прокрутки
            teamScroll.scrollLeft = scrollLeft - walk;
        });

        // Тач-устройства
        let touchStartX = 0;
        let touchScrollLeft = 0;

        teamScroll.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].pageX - teamScroll.offsetLeft;
            touchScrollLeft = teamScroll.scrollLeft;
        });

        teamScroll.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const x = e.touches[0].pageX - teamScroll.offsetLeft;
            const walk = (x - touchStartX) * 2;
            teamScroll.scrollLeft = touchScrollLeft - walk;
        });

        // Устанавливаем курсор по умолчанию
        teamScroll.style.cursor = 'grab';
    }

    // 6. Блокировка прокрутки страницы при открытом мобильном меню
    const navbarCollapse = document.querySelector('#navbarNav');
    let scrollPosition = 0;
    
    if (navbarCollapse) {
        // Сохраняем позицию скролла перед блокировкой
        const saveScrollPosition = () => {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        };

        // Блокируем прокрутку
        const lockScroll = () => {
            if (window.innerWidth <= 991) {
                saveScrollPosition();
                document.body.style.top = `-${scrollPosition}px`;
                document.body.classList.add('menu-open');
                document.documentElement.classList.add('menu-open');
            }
        };

        // Разблокируем прокрутку
        const unlockScroll = () => {
            document.body.classList.remove('menu-open');
            document.documentElement.classList.remove('menu-open');
            document.body.style.top = '';
            window.scrollTo(0, scrollPosition);
        };

        // Используем события Bootstrap для отслеживания открытия/закрытия меню
        navbarCollapse.addEventListener('show.bs.collapse', function() {
            lockScroll();
        });

        navbarCollapse.addEventListener('hide.bs.collapse', function() {
            unlockScroll();
        });

        // Закрытие меню при клике на ссылки и переход к выбранному элементу
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link, .navbar-nav .btn-pill');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Проверяем, что мы на мобильном экране и меню открыто
                if (window.innerWidth <= 991 && navbarCollapse.classList.contains('show')) {
                    // Если это ссылка на модальное окно поддержки
                    if (this.hasAttribute('data-bs-toggle') && this.getAttribute('data-bs-toggle') === 'modal') {
                        // Закрываем меню перед открытием модального окна
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                        return;
                    }
                    
                    // Если это якорная ссылка (#about, #gallery, #team)
                    if (href && href.startsWith('#') && href !== '#') {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Получаем или создаем экземпляр Bootstrap Collapse
                        let bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (!bsCollapse) {
                            bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });
                        }
                        
                        // Закрываем меню
                        bsCollapse.hide();
                        
                        // Ждем закрытия меню и затем переходим к элементу
                        const transitionHandler = function() {
                            navbarCollapse.removeEventListener('hidden.bs.collapse', transitionHandler);
                            
                            // Разблокируем прокрутку
                            unlockScroll();
                            
                            // Плавный переход к элементу
                            const targetElement = document.querySelector(href);
                            if (targetElement) {
                                setTimeout(() => {
                                    targetElement.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });
                                }, 150);
                            }
                        };
                        
                        navbarCollapse.addEventListener('hidden.bs.collapse', transitionHandler, { once: true });
                    }
                }
            });
        });

        // Обработка изменения размера окна
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                unlockScroll();
            }
        });

        // Предотвращаем прокрутку при открытом меню (дополнительная защита)
        document.addEventListener('touchmove', function(e) {
            if (document.body.classList.contains('menu-open') && window.innerWidth <= 991) {
                // Разрешаем прокрутку только внутри меню, если нужно
                const target = e.target.closest('.navbar-collapse');
                if (!target) {
                    e.preventDefault();
                }
            }
        }, { passive: false });

        document.addEventListener('wheel', function(e) {
            if (document.body.classList.contains('menu-open') && window.innerWidth <= 991) {
                e.preventDefault();
            }
        }, { passive: false });
    }
});

