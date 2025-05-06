// Функціонал акордеону
document.addEventListener('DOMContentLoaded', function() {
    initAccordions();
});

function initAccordions() {
    const accordionToggles = document.querySelectorAll('.accordion-toggle');
    
    // Закриваємо всі акордеони спочатку
    document.querySelectorAll('.accordion-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Відкриваємо перший за замовчуванням
    if (accordionToggles.length > 0) {
        accordionToggles[0].classList.add('active');
        const firstContent = accordionToggles[0].nextElementSibling;
        if (firstContent && firstContent.classList.contains('accordion-content')) {
            firstContent.style.display = 'block';
        }
    }
    
    // Додаємо слухачі подій для кожного тоглу
    accordionToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            // Перемикаємо стан активності для поточного елемента
            this.classList.toggle('active');
            
            // Знаходимо відповідний контент та перемикаємо його відображення
            const content = this.nextElementSibling;
            if (content && content.classList.contains('accordion-content')) {
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            }
        });
    });
} 