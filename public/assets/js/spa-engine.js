/**
 * Tyche Monolith SPA Engine & Accordion Sidebar
 * Intercepts internal admin links and form submissions for instant React-like transitions,
 * with collapsible accordion sidebar persistence.
 */

document.addEventListener('DOMContentLoaded', () => {
    const contentArea = document.getElementById('app-content');
    const loaderBar = document.getElementById('spa-loader-bar');

    // Sidebar Accordion System
    function initSidebarAccordion() {
        const groups = document.querySelectorAll('.sidebar .nav-group');
        let savedStates = {};
        try {
            savedStates = JSON.parse(localStorage.getItem('tyche_sidebar_accordion')) || {};
        } catch (e) {}

        groups.forEach(group => {
            const groupId = group.getAttribute('id');
            const header = group.querySelector('.nav-group-header');
            const hasActiveLink = group.querySelector('.nav-item-link.active') !== null;

            if (header) {
                // If group contains currently active page link, auto-expand it!
                if (hasActiveLink) {
                    group.classList.remove('collapsed');
                    if (groupId) savedStates[groupId] = 'open';
                } else if (groupId && savedStates[groupId] === 'closed') {
                    group.classList.add('collapsed');
                }

                // Add toggle click listener (bind once)
                if (!header.hasAttribute('data-accordion-bound')) {
                    header.setAttribute('data-accordion-bound', 'true');
                    header.addEventListener('click', () => {
                        const isCollapsed = group.classList.toggle('collapsed');
                        if (groupId) {
                            savedStates[groupId] = isCollapsed ? 'closed' : 'open';
                            try {
                                localStorage.setItem('tyche_sidebar_accordion', JSON.stringify(savedStates));
                            } catch (e) {}
                        }
                    });
                }
            }
        });
    }

    // Initialize Accordion on initial load
    initSidebarAccordion();

    if (!contentArea) return;

    function showLoader() {
        if (loaderBar) {
            loaderBar.style.width = '45%';
            loaderBar.style.opacity = '1';
        }
    }

    function completeLoader() {
        if (loaderBar) {
            loaderBar.style.width = '100%';
            setTimeout(() => {
                loaderBar.style.opacity = '0';
                setTimeout(() => {
                    loaderBar.style.width = '0%';
                }, 300);
            }, 150);
        }
    }

    function updateActiveSidebarLinks(newPath) {
        document.querySelectorAll('.sidebar .nav-item-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href) {
                try {
                    const linkPath = new URL(href, window.location.origin).pathname;
                    if (linkPath === newPath || (newPath !== '/dashboard' && linkPath !== '/dashboard' && newPath.startsWith(linkPath))) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                } catch (e) {}
            }
        });

        // Re-evaluate accordion expansion for newly active group
        initSidebarAccordion();
    }

    function reinitializeDynamicComponents() {
        // Re-initialize Bootstrap modals & tooltips
        if (window.bootstrap) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                try { new bootstrap.Tooltip(el); } catch(e){}
            });
        }

        // Re-execute scripts inside #app-content
        if (contentArea) {
            contentArea.querySelectorAll('script').forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                if (oldScript.parentNode) {
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                }
            });
        }
    }

    async function loadPage(url, pushState = true) {
        showLoader();
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-SPA-Request': '1'
                }
            });

            let finalUrl = response.url || url;
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newContent = doc.getElementById('app-content');
            if (newContent) {
                // Smooth content transition
                contentArea.style.opacity = '0.4';
                setTimeout(() => {
                    contentArea.innerHTML = newContent.innerHTML;
                    contentArea.style.opacity = '1';
                    document.title = doc.title || document.title;

                    if (pushState) {
                        window.history.pushState({ url: finalUrl }, '', finalUrl);
                    }

                    const newPath = new URL(finalUrl, window.location.origin).pathname;
                    updateActiveSidebarLinks(newPath);
                    reinitializeDynamicComponents();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 80);
            } else {
                window.location.href = finalUrl;
            }
        } catch (err) {
            console.error('SPA Navigation Error:', err);
            window.location.href = url;
        } finally {
            completeLoader();
        }
    }

    // Intercept Click Events
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.getAttribute('target') === '_blank' || link.hasAttribute('data-no-spa')) {
            return;
        }

        try {
            const targetUrl = new URL(href, window.location.origin);
            if (targetUrl.origin === window.location.origin) {
                const path = targetUrl.pathname;
                if (path.startsWith('/admin') || path.startsWith('/dashboard') || path.startsWith('/account') || path.startsWith('/student') || path.startsWith('/faculty')) {
                    e.preventDefault();
                    loadPage(targetUrl.href);
                }
            }
        } catch (err) {}
    });

    // Intercept Form Submissions (for POST / PUT forms in admin)
    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (form.hasAttribute('data-no-spa') || form.getAttribute('target') === '_blank') {
            return;
        }

        const action = form.getAttribute('action') || window.location.href;
        try {
            const targetUrl = new URL(action, window.location.origin);
            if (targetUrl.origin === window.location.origin && (targetUrl.pathname.startsWith('/admin') || targetUrl.pathname.startsWith('/dashboard'))) {
                e.preventDefault();
                showLoader();

                const formData = new FormData(form);
                const response = await fetch(targetUrl.href, {
                    method: form.getAttribute('method') || 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-SPA-Request': '1'
                    }
                });

                let redirectUrl = response.url || targetUrl.href;
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newContent = doc.getElementById('app-content');
                if (newContent) {
                    contentArea.style.opacity = '0.4';
                    setTimeout(() => {
                        contentArea.innerHTML = newContent.innerHTML;
                        contentArea.style.opacity = '1';
                        document.title = doc.title || document.title;
                        window.history.pushState({ url: redirectUrl }, '', redirectUrl);
                        updateActiveSidebarLinks(new URL(redirectUrl, window.location.origin).pathname);
                        reinitializeDynamicComponents();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }, 80);
                } else {
                    window.location.href = redirectUrl;
                }
            }
        } catch (err) {
            console.error('SPA Form Error:', err);
        } finally {
            completeLoader();
        }
    });

    // Handle Browser Back / Forward buttons
    window.addEventListener('popstate', () => {
        loadPage(window.location.href, false);
    });
});
