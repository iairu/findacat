/**
 * FindACat Theme System
 * Multi-theme support with localStorage persistence
 */

class ThemeSystem {
    constructor() {
        this.themes = {
            classic: {
                name: 'Classic',
                description: 'Modern purple gradient theme',
                icon: '🎨',
                preview: 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)'
            },
            neon: {
                name: 'Neon',
                description: 'Cyberpunk neon lights',
                icon: '⚡',
                preview: 'linear-gradient(135deg, #00ffff 0%, #ff00ff 100%)'
            },
            retro: {
                name: 'Retro',
                description: '80s/90s vintage style',
                icon: '📺',
                preview: 'linear-gradient(135deg, #e67e22 0%, #d35400 100%)'
            },
            future: {
                name: 'Future',
                description: 'Futuristic sci-fi theme',
                icon: '🚀',
                preview: 'linear-gradient(135deg, #00d9ff 0%, #00ff88 100%)'
            },
            soothing: {
                name: 'Soothing',
                description: 'Calm and peaceful zen',
                icon: '🍃',
                preview: 'linear-gradient(135deg, #4caf50 0%, #81c784 100%)'
            },
            macos: {
                name: 'macOS',
                description: 'Apple design language',
                icon: '🍎',
                preview: 'linear-gradient(135deg, #007aff 0%, #5856d6 100%)'
            },
            windows: {
                name: 'Windows',
                description: 'Microsoft Fluent design',
                icon: '🪟',
                preview: 'linear-gradient(135deg, #0078d4 0%, #107c10 100%)'
            },
            ocean: {
                name: 'Ocean',
                description: 'Deep blue sea vibes',
                icon: '🌊',
                preview: 'linear-gradient(135deg, #00acc1 0%, #0097a7 100%)'
            },
            sunset: {
                name: 'Sunset',
                description: 'Warm evening colors',
                icon: '🌅',
                preview: 'linear-gradient(135deg, #ff6f00 0%, #ff5722 100%)'
            },
            midnight: {
                name: 'Midnight',
                description: 'Dark blue night theme',
                icon: '🌙',
                preview: 'linear-gradient(135deg, #415a77 0%, #778da9 100%)'
            }
        };

        this.currentTheme = this.loadTheme();
        this.init();
    }

    init() {
        // Apply saved theme
        this.applyTheme(this.currentTheme);

        // Create theme selector if on homepage
        this.createThemeSelector();

        // Listen for storage changes (multi-tab sync)
        window.addEventListener('storage', (e) => {
            if (e.key === 'selected_theme') {
                this.applyTheme(e.newValue || 'classic');
            }
        });
    }

    loadTheme() {
        return localStorage.getItem('selected_theme') || 'classic';
    }

    saveTheme(theme) {
        localStorage.setItem('selected_theme', theme);
    }

    applyTheme(theme) {
        if (!this.themes[theme]) {
            theme = 'classic';
        }

        // Set data attribute on html element
        document.documentElement.setAttribute('data-theme', theme);
        this.currentTheme = theme;

        // Update theme toggle icon if needed
        const themeIcon = document.querySelector('.theme-icon');
        if (themeIcon && this.themes[theme]) {
            themeIcon.textContent = this.themes[theme].icon;
        }

        // Trigger event
        document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));

        toast?.success(`${this.themes[theme].name} theme applied!`, 2000);
    }

    switchTheme(theme) {
        this.applyTheme(theme);
        this.saveTheme(theme);
    }

    createThemeSelector() {
        // Only on homepage/search page
        const isHomepage = window.location.pathname === '/' ||
                          window.location.pathname.includes('search') ||
                          window.location.pathname.includes('profile-search');

        if (!isHomepage) return;

        // Check if already exists
        if (document.getElementById('theme-selector-panel')) return;

        const panel = document.createElement('div');
        panel.id = 'theme-selector-panel';
        panel.className = 'theme-selector-panel';
        panel.innerHTML = `
            <div class="theme-selector-header">
                <h3>🎨 Choose Your Theme</h3>
                <p>Pick a style that suits your mood</p>
            </div>
            <div class="theme-selector-grid">
                ${Object.keys(this.themes).map(themeKey => `
                    <div class="theme-card ${this.currentTheme === themeKey ? 'active' : ''}"
                         data-theme="${themeKey}"
                         onclick="themeSystem.switchTheme('${themeKey}')">
                        <div class="theme-preview" style="background: ${this.themes[themeKey].preview}">
                            <div class="theme-icon">${this.themes[themeKey].icon}</div>
                        </div>
                        <div class="theme-info">
                            <div class="theme-name">${this.themes[themeKey].name}</div>
                            <div class="theme-description">${this.themes[themeKey].description}</div>
                        </div>
                        <div class="theme-checkmark">✓</div>
                    </div>
                `).join('')}
            </div>
        `;

        // Insert after hero banner or at top of container
        const container = document.querySelector('.container') || document.querySelector('main');
        if (container) {
            const heroBanner = container.querySelector('.hero-banner');
            if (heroBanner) {
                heroBanner.after(panel);
            } else {
                container.insertBefore(panel, container.firstChild);
            }
        }

        // Add event listener for theme changes
        document.addEventListener('themeChanged', (e) => {
            // Update active state
            document.querySelectorAll('.theme-card').forEach(card => {
                card.classList.remove('active');
            });
            const activeCard = document.querySelector(`.theme-card[data-theme="${e.detail.theme}"]`);
            if (activeCard) {
                activeCard.classList.add('active');
            }
        });
    }
}

// Initialize theme system
window.themeSystem = new ThemeSystem();

// Also update the theme toggle button to cycle through themes
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        // Store original click handler
        const originalHandler = themeToggle.onclick;

        // Add long-press for theme selector
        let pressTimer;

        themeToggle.addEventListener('mousedown', (e) => {
            pressTimer = setTimeout(() => {
                showQuickThemeSelector(e);
            }, 500);
        });

        themeToggle.addEventListener('mouseup', () => {
            clearTimeout(pressTimer);
        });

        themeToggle.addEventListener('touchstart', (e) => {
            pressTimer = setTimeout(() => {
                showQuickThemeSelector(e);
            }, 500);
        });

        themeToggle.addEventListener('touchend', () => {
            clearTimeout(pressTimer);
        });
    }
});

function showQuickThemeSelector(e) {
    e.preventDefault();
    e.stopPropagation();

    // Remove existing selector
    const existing = document.querySelector('.quick-theme-selector');
    if (existing) {
        existing.remove();
        return;
    }

    const selector = document.createElement('div');
    selector.className = 'quick-theme-selector';
    selector.innerHTML = `
        <div class="quick-theme-header">Select Theme</div>
        <div class="quick-theme-list">
            ${Object.keys(themeSystem.themes).map(themeKey => `
                <div class="quick-theme-item ${themeSystem.currentTheme === themeKey ? 'active' : ''}"
                     onclick="themeSystem.switchTheme('${themeKey}'); document.querySelector('.quick-theme-selector').remove();">
                    <span class="quick-theme-icon">${themeSystem.themes[themeKey].icon}</span>
                    <span class="quick-theme-name">${themeSystem.themes[themeKey].name}</span>
                    <span class="quick-theme-check">✓</span>
                </div>
            `).join('')}
        </div>
    `;

    document.body.appendChild(selector);

    // Close on outside click
    setTimeout(() => {
        document.addEventListener('click', function closeSelector(e) {
            if (!selector.contains(e.target)) {
                selector.remove();
                document.removeEventListener('click', closeSelector);
            }
        });
    }, 100);

    toast.info('Long-press theme button to see all themes!', 3000);
}

// Add animated cats to homepage
class AnimatedCats {
    constructor() {
        this.init();
    }

    init() {
        // Only on homepage
        const isHomepage = window.location.pathname === '/' ||
                          window.location.pathname.includes('search') ||
                          window.location.pathname.includes('profile-search');

        if (!isHomepage) return;

        this.createCats();
    }

    createCats() {
        // Check if already exists
        if (document.querySelector('.animated-cats-container')) return;

        const container = document.createElement('div');
        container.className = 'animated-cats-container';

        // Create 8 animated cats
        for (let i = 1; i <= 8; i++) {
            const cat = document.createElement('div');
            cat.className = `animated-cat cat-${i}`;

            // Add click event for fun interaction
            cat.addEventListener('click', () => {
                cat.style.animation = 'none';
                setTimeout(() => {
                    cat.style.animation = '';
                }, 10);

                // Random meow sound text
                const meows = ['Meow!', 'Purr~', 'Mrow!', '😸', '😻', '😺'];
                const meow = meows[Math.floor(Math.random() * meows.length)];

                const meowText = document.createElement('div');
                meowText.textContent = meow;
                meowText.style.cssText = `
                    position: absolute;
                    top: -30px;
                    left: 50%;
                    transform: translateX(-50%);
                    color: var(--primary);
                    font-weight: 700;
                    font-size: 20px;
                    animation: float-up 1s ease-out;
                    pointer-events: none;
                `;
                cat.appendChild(meowText);

                setTimeout(() => meowText.remove(), 1000);
            });

            container.appendChild(cat);
        }

        // Add to body
        document.body.insertBefore(container, document.body.firstChild);

        // Add float-up animation
        if (!document.getElementById('float-up-animation')) {
            const style = document.createElement('style');
            style.id = 'float-up-animation';
            style.textContent = `
                @keyframes float-up {
                    to {
                        opacity: 0;
                        transform: translateX(-50%) translateY(-50px);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }
}

// Initialize animated cats
window.animatedCats = new AnimatedCats();

console.log('🎨 Theme System Loaded with', Object.keys(themeSystem.themes).length, 'themes');
