document.addEventListener('DOMContentLoaded', () => {
    const content = document.getElementById('app-content');
    const links = document.querySelectorAll('#side_items a');
    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('open_btn');

    openBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('open-sidebar');
    });

    const pageCache = new Map();

    const injectedStyles = new Set();
    const injectedStyleTexts = new Set();

    function baseFor(pagePath) {
        try {
            const full = new URL(pagePath, location.href);
            full.pathname = full.pathname.replace(/\/[^/]*$/, '/');
            return full.href;
        } catch (e) {
            return location.href;
        }
    }

    function resolveAttrUrls(root, attrName, base) {
        const els = root.querySelectorAll(`[${attrName}]`);
        els.forEach(el => {
            const val = el.getAttribute(attrName);
            if (!val) return;
            if (/^(?:https?:|\/\/|data:|\/)/i.test(val)) return;
            try {
                const abs = new URL(val, base).href;
                el.setAttribute(attrName, abs);
            } catch (err) {
            }
        });
    }

    async function injectLinksToHeadScoped(linksArray, base) {
        for (const link of linksArray) {
            const href = link.getAttribute('href');
            if (!href) continue;
            if (injectedStyles.has(href)) continue;

            try {
                const res = await fetch(href, { cache: 'no-store' });
                if (!res.ok) {
                    const newLinkFallback = document.createElement('link');
                    Array.from(link.attributes).forEach(attr => newLinkFallback.setAttribute(attr.name, attr.value));
                    document.head.appendChild(newLinkFallback);
                    injectedStyles.add(href);
                    continue;
                }

                let cssText = await res.text();

                const scope = '#app-content';
                cssText = cssText.replace(/\/\*[\s\S]*?\*\//g, '');

                cssText = cssText.replace(/([^{@}]+){([^}]*)}/g, (m, selector, body) => {
                    if (/^\s*@/.test(selector)) return m;
                    const prefixed = selector
                        .split(',')
                        .map(s => {
                            s = s.trim();
                            if (s.startsWith(scope)) return s;
                            if (s === 'html' || s === 'body') return `${scope} ${s}`;
                            return `${scope} ${s}`;
                        })
                        .join(', ');
                    return `${prefixed} {${body}}`;
                });

                const newStyle = document.createElement('style');
                newStyle.textContent = cssText;
                document.head.appendChild(newStyle);
                injectedStyles.add(href);
            } catch (err) {
                console.warn('Não foi possível processar CSS para', href, err);
                const newLinkFallback = document.createElement('link');
                Array.from(link.attributes).forEach(attr => newLinkFallback.setAttribute(attr.name, attr.value));
                document.head.appendChild(newLinkFallback);
                injectedStyles.add(href);
            }
        }
    }


    function injectStylesToHead(styleNodes) {
        styleNodes.forEach(s => {
            const txt = s.textContent?.trim();
            if (!txt) return;
            if (injectedStyleTexts.has(txt)) return;
            const newStyle = document.createElement('style');
            newStyle.textContent = txt;
            document.head.appendChild(newStyle);
            injectedStyleTexts.add(txt);
        });
    }

    function executeScripts(scriptNodes) {
        const promises = [];

        scriptNodes.forEach(s => {
            const newScript = document.createElement('script');

            Array.from(s.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));

            const src = s.getAttribute('src');
            if (src) {
                const p = new Promise((resolve, reject) => {
                    newScript.addEventListener('load', resolve);
                    newScript.addEventListener('error', () => reject(new Error('Failed to load script ' + src)));
                });
                promises.push(p);
                document.head.appendChild(newScript);
            } else {
                newScript.textContent = s.textContent;
                content.appendChild(newScript);
            }
        });

        return Promise.allSettled(promises);
    }

    async function loadPage(pagePath) {
        if (!pagePath) {
            content.innerHTML = '<p>Página não encontrada.</p>';
            return;
        }

        content.innerHTML = '<p>Carregando...</p>';

        let text;
        if (pageCache.has(pagePath)) {
            text = pageCache.get(pagePath).text;
        } else {
            try {
                const res = await fetch(pagePath, { cache: 'no-store' });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                text = await res.text();
                pageCache.set(pagePath, { text });
            } catch (err) {
                console.error('Erro ao carregar', pagePath, err);
                content.innerHTML = `<p>Erro ao carregar <strong>${pagePath}</strong></p>`;
                return;
            }
        }

        const parser = new DOMParser();
        const doc = parser.parseFromString(text, 'text/html');

        const base = baseFor(pagePath);

        resolveAttrUrls(doc, 'href', base);
        resolveAttrUrls(doc, 'src', base);
        resolveAttrUrls(doc, 'srcset', base);

        const linkNodes = Array.from(doc.querySelectorAll('link[rel="stylesheet"]'));
        await injectLinksToHeadScoped(linkNodes, base);


        const styleNodes = Array.from(doc.querySelectorAll('style'));
        injectStylesToHead(styleNodes);

        const fragment = document.createDocumentFragment();
        Array.from(doc.body.childNodes).forEach(node => {
            const tag = (node.nodeName || '').toLowerCase();
            if (tag === 'script' || tag === 'link' || tag === 'style') return;
            fragment.appendChild(node.cloneNode(true));
        });

        content.innerHTML = '';
        content.appendChild(fragment);

        const scriptNodes = Array.from(doc.querySelectorAll('script'));
        try {
            await executeScripts(scriptNodes);
        } catch (e) {
            console.warn('Algum script externo não pôde ser carregado:', e);
        }

        setTimeout(() => {
            const focusTarget = content.querySelector('h1, h2, [tabindex], main, section');
            if (focusTarget) {
                focusTarget.setAttribute('tabindex', '-1');
                focusTarget.focus();
            }
        }, 40);
    }

    function setActiveByHash(hash) {
        links.forEach(a => {
            const linkHash = a.getAttribute('href');
            const li = a.closest('li.side-item');
            if (linkHash === hash) {
                li && li.classList.add('active');
            } else {
                li && li.classList.remove('active');
            }
        });
    }

    links.forEach(a => {
        a.addEventListener('click', (e) => {
            e.preventDefault();
            const href = a.getAttribute('href') || '#';
            if (location.hash !== href) {
                location.hash = href;
            } else {
                handleHashChange();
            }
        });
    });

    function handleHashChange() {
        const hash = location.hash || '#/institution-home';
        setActiveByHash(hash);
        const anchor = Array.from(links).find(a => a.getAttribute('href') === hash);
        const pageToLoad = anchor ? anchor.dataset.page : 'institution-home.html';
        loadPage(pageToLoad);
    }

    window.addEventListener('hashchange', handleHashChange, false);
    handleHashChange();
});