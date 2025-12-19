document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Плавный скролл при клике на навигацию (если нужны кастомные эффекты)
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
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
            const input = e.target.closest('.input-group-custom').querySelector('input');
            if (input) {
                input.value = '';
                input.focus();
            }
        });
    });

    // 3. Обработка формы предзаказа (имитация)
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.addEventListener('submit', (e) => {
            e.preventDefault();
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
                alert("Спасибо за предзаказ! (Демонстрация)");
            }, 2000);
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
});