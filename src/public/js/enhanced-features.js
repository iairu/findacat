/**
 * FindACat Enhanced Features
 * Drag-and-drop uploads, PawPeds integration, SPA navigation, live stats
 */

// ==========================================
// SPA-LIKE PAGE NAVIGATION (YouTube Style)
// ==========================================
class SPANavigator {
    constructor() {
        this.init();
    }

    init() {
        // Intercept all internal links
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');

            if (link &&
                link.href &&
                link.host === window.location.host &&
                !link.getAttribute('target') &&
                !link.hasAttribute('download') &&
                !link.href.startsWith('javascript:') &&
                !link.href.includes('#') &&
                !link.closest('[data-no-spa]')) {

                e.preventDefault();
                this.navigateTo(link.href);
            }
        });

        // Handle browser back/forward
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                this.loadPage(e.state.url, false);
            }
        });
    }

    async navigateTo(url) {
        // Start loading indicators
        progressBar.start();
        document.body.classList.add('page-loading');

        // Add to history
        window.history.pushState({ url }, '', url);

        // Load the page
        await this.loadPage(url, true);
    }

    async loadPage(url, addToHistory = true) {
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Page load failed');
            }

            const html = await response.text();

            // Parse the HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extract main content
            const newContent = doc.querySelector('#main-content') || doc.querySelector('.container');
            const currentContent = document.querySelector('#main-content') || document.querySelector('.container');

            if (newContent && currentContent) {
                // Smooth fade out
                currentContent.style.opacity = '0';

                setTimeout(() => {
                    // Replace content
                    currentContent.innerHTML = newContent.innerHTML;

                    // Update title
                    document.title = doc.title;

                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    // Fade in
                    currentContent.style.opacity = '1';

                    // Re-initialize page-specific scripts
                    this.reinitScripts();

                    // Complete loading
                    progressBar.complete();
                    document.body.classList.remove('page-loading');

                    toast.success('Page loaded!', 1500);
                }, 300);
            } else {
                // Fallback to traditional navigation
                window.location.href = url;
            }

        } catch (error) {
            console.error('SPA navigation error:', error);
            toast.error('Failed to load page');
            progressBar.reset();
            document.body.classList.remove('page-loading');

            // Fallback
            window.location.href = url;
        }
    }

    reinitScripts() {
        // Re-initialize tooltips
        if (window.tooltipManager) {
            window.tooltipManager.init();
        }

        // Re-initialize favorites UI
        if (window.favorites) {
            window.favorites.updateUI();
        }

        // Re-init Select2 if present
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('select').select2();
        }

        // Trigger custom event for other scripts
        document.dispatchEvent(new CustomEvent('spa:pageLoaded'));
    }
}

// Initialize SPA navigation
window.spaNavigator = new SPANavigator();

// ==========================================
// DRAG AND DROP PHOTO UPLOAD
// ==========================================
class DragDropUploader {
    constructor() {
        this.init();
    }

    init() {
        // Find all file inputs for photos
        const photoInputs = document.querySelectorAll('input[type="file"][accept*="image"]');

        photoInputs.forEach(input => {
            this.enhanceInput(input);
        });
    }

    enhanceInput(input) {
        // Create drop zone wrapper
        const dropZone = document.createElement('div');
        dropZone.className = 'drag-drop-zone';
        dropZone.innerHTML = `
            <div class="drag-drop-inner">
                <div class="drag-drop-icon">📸</div>
                <div class="drag-drop-text">
                    <strong>Drag & drop photo here</strong>
                    <span>or click to browse</span>
                </div>
                <div class="drag-drop-preview"></div>
            </div>
        `;

        // Insert after input
        input.style.display = 'none';
        input.parentElement.insertBefore(dropZone, input.nextSibling);

        // Handle clicks
        dropZone.addEventListener('click', () => input.click());

        // Handle drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, this.preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-over');
            });
        });

        // Handle drop
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                this.handleFiles(files, dropZone);
                toast.success('Photo added!');
            }
        });

        // Handle file selection
        input.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                this.handleFiles(e.target.files, dropZone);
            }
        });
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleFiles(files, dropZone) {
        const file = files[0];

        if (file && file.type.startsWith('image/')) {
            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = dropZone.querySelector('.drag-drop-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                dropZone.classList.add('has-file');
            };
            reader.readAsDataURL(file);
        }
    }
}

// Initialize drag-drop uploader
window.dragDropUploader = new DragDropUploader();

// ==========================================
// PAWPEDS INTEGRATION
// ==========================================
class PawPedsIntegration {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.addFetchButtons();
        });

        // Re-init on SPA page load
        document.addEventListener('spa:pageLoaded', () => {
            this.addFetchButtons();
        });
    }

    addFetchButtons() {
        // Find forms with registration number fields
        const regInputs = document.querySelectorAll('input[name*="reg_num"], input[name*="registration"]');

        regInputs.forEach(input => {
            // Don't add button if already exists
            if (input.nextElementSibling?.classList.contains('pawpeds-fetch-btn')) {
                return;
            }

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-info pawpeds-fetch-btn';
            button.innerHTML = '🐾 Fetch from PawPeds';
            button.style.marginTop = '10px';

            button.addEventListener('click', () => this.fetchFromPawPeds(input));

            input.parentElement.appendChild(button);
        });
    }

    async fetchFromPawPeds(regInput) {
        const regNumber = regInput.value.trim();

        if (!regNumber) {
            toast.warning('Please enter a registration number first');
            return;
        }

        const button = regInput.nextElementSibling;
        button.disabled = true;
        button.innerHTML = '⏳ Fetching...';

        toast.info('Fetching data from PawPeds...', 3000);

        try {
            const response = await fetch('/api/fetch-pawpeds', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    reg_number: regNumber,
                    breed: 'nfo' // Default, can be made dynamic
                })
            });

            const result = await response.json();

            if (result.success && result.data) {
                this.fillFormWithData(result.data);
                toast.success('Data fetched successfully!');
            } else {
                toast.error(result.message || 'No data found');
            }

        } catch (error) {
            console.error('PawPeds fetch error:', error);
            toast.error('Failed to fetch data from PawPeds');
        } finally {
            button.disabled = false;
            button.innerHTML = '🐾 Fetch from PawPeds';
        }
    }

    fillFormWithData(data) {
        const fieldMappings = {
            'full_name': ['full_name', 'name', 'cat_name'],
            'ems_color': ['ems_color', 'color', 'ems'],
            'breed': ['breed'],
            'dob': ['dob', 'date_of_birth', 'birth_date'],
            'gender_id': ['gender_id', 'gender'],
            'breeder': ['breeder'],
            'current_owner': ['current_owner', 'owner'],
            'titles_before_name': ['titles_before_name', 'titles_before'],
            'titles_after_name': ['titles_after_name', 'titles_after'],
        };

        let filledCount = 0;

        Object.keys(data).forEach(key => {
            const possibleNames = fieldMappings[key] || [key];

            possibleNames.forEach(name => {
                const input = document.querySelector(`input[name="${name}"], select[name="${name}"], textarea[name="${name}"]`);

                if (input && !input.value) {
                    input.value = data[key];
                    input.classList.add('auto-filled');

                    // Trigger change event
                    input.dispatchEvent(new Event('change', { bubbles: true }));

                    filledCount++;
                }
            });
        });

        if (filledCount > 0) {
            toast.success(`${filledCount} fields auto-filled!`, 3000);

            // Highlight auto-filled fields briefly
            setTimeout(() => {
                document.querySelectorAll('.auto-filled').forEach(el => {
                    el.classList.remove('auto-filled');
                });
            }, 3000);
        }
    }
}

// Initialize PawPeds integration
window.pawPedsIntegration = new PawPedsIntegration();

// ==========================================
// LIVE STATS INDICATOR
// ==========================================
class LiveStatsIndicator {
    constructor() {
        this.stats = {
            total_cats: 0,
            living_cats: 0
        };
        this.init();
    }

    init() {
        this.createIndicator();
        this.fetchStats();

        // Update every 5 minutes
        setInterval(() => this.fetchStats(), 300000);
    }

    createIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'live-stats-indicator';
        indicator.className = 'live-stats-indicator';
        indicator.innerHTML = `
            <span class="stats-blink">●</span>
            <span class="stats-text">
                <span class="stats-number">...</span> cats meowing
            </span>
        `;

        // Add to navbar
        const navbar = document.querySelector('.navbar-nav');
        if (navbar) {
            const li = document.createElement('li');
            li.appendChild(indicator);
            navbar.appendChild(li);
        }
    }

    async fetchStats() {
        try {
            const response = await fetch('/api/stats');
            const data = await response.json();

            if (data.total_cats !== undefined) {
                this.stats = data;
                this.updateIndicator();
            }
        } catch (error) {
            console.error('Stats fetch error:', error);
        }
    }

    updateIndicator() {
        const numberSpan = document.querySelector('.stats-number');
        if (numberSpan) {
            // Animate number change
            this.animateNumber(numberSpan, parseInt(numberSpan.textContent) || 0, this.stats.total_cats);
        }
    }

    animateNumber(element, from, to) {
        const duration = 1000;
        const steps = 20;
        const stepValue = (to - from) / steps;
        let current = from;
        let step = 0;

        const interval = setInterval(() => {
            current += stepValue;
            step++;

            element.textContent = Math.round(current);

            if (step >= steps) {
                element.textContent = to;
                clearInterval(interval);
            }
        }, duration / steps);
    }
}

// Initialize live stats
window.liveStatsIndicator = new LiveStatsIndicator();

// ==========================================
// ENHANCED BACKUP SYSTEM
// ==========================================
class EnhancedBackupSystem {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.enhanceBackupPage();
        });
    }

    enhanceBackupPage() {
        // Check if we're on the backup page
        const backupForm = document.querySelector('form[action*="backups"]');
        if (!backupForm) return;

        // Add drag-drop zone for imports
        const fileInputs = document.querySelectorAll('input[type="file"]');

        fileInputs.forEach(input => {
            this.addDragDropToBackup(input);
        });

        // Add progress bars to export/import buttons
        this.addProgressToButtons();
    }

    addDragDropToBackup(input) {
        const dropZone = document.createElement('div');
        dropZone.className = 'backup-drag-zone';
        dropZone.innerHTML = `
            <div class="backup-drag-inner">
                <div class="backup-drag-icon">📁</div>
                <div class="backup-drag-text">
                    <strong>Drop CSV file here</strong>
                    <span>or click to browse</span>
                </div>
                <div class="backup-file-name"></div>
                <div class="backup-progress">
                    <div class="backup-progress-bar"></div>
                    <div class="backup-progress-text">0%</div>
                </div>
            </div>
        `;

        input.style.display = 'none';
        input.parentElement.insertBefore(dropZone, input.nextSibling);

        // Handle clicks
        dropZone.addEventListener('click', () => input.click());

        // Drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-active');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-active');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                this.showFileName(dropZone, files[0]);
                toast.success('File ready for import!');
            }
        });

        input.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                this.showFileName(dropZone, e.target.files[0]);
            }
        });
    }

    showFileName(dropZone, file) {
        const fileNameEl = dropZone.querySelector('.backup-file-name');
        fileNameEl.textContent = `📄 ${file.name} (${this.formatBytes(file.size)})`;
        dropZone.classList.add('has-file');
    }

    formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    addProgressToButtons() {
        const submitButtons = document.querySelectorAll('button[type="submit"], input[type="submit"]');

        submitButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                if (button.form) {
                    const formData = new FormData(button.form);

                    // If has file, show progress
                    let hasFile = false;
                    for (let pair of formData.entries()) {
                        if (pair[1] instanceof File && pair[1].size > 0) {
                            hasFile = true;
                            break;
                        }
                    }

                    if (hasFile) {
                        this.showUploadProgress(button);
                    }
                }
            });
        });
    }

    showUploadProgress(button) {
        button.disabled = true;
        button.dataset.originalText = button.textContent || button.value;
        button.textContent = 'Uploading... 0%';

        // Simulate progress (in real implementation, use XMLHttpRequest for actual progress)
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 95) progress = 95;

            button.textContent = `Uploading... ${Math.round(progress)}%`;

            if (progress >= 95) {
                clearInterval(interval);
                button.textContent = 'Processing...';
            }
        }, 200);
    }
}

// Initialize enhanced backup system
window.enhancedBackupSystem = new EnhancedBackupSystem();

console.log('🚀 FindACat Enhanced Features Loaded');
