/* =========================================================
   UI ENHANCE v2 — animasi, kursor, dan UX tambahan.
   Murni front-end: tidak mengubah route, controller, nama field, atau data.
   Setiap modul dibungkus try/catch agar satu error tidak merusak halaman.
   ========================================================= */
(function () {
    'use strict';

    const $ = (s, r = document) => r.querySelector(s);
    const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const safe = (name, fn) => { try { fn(); } catch (e) { console.warn('[ui-enhance]', name, e); } };
    const lerp = (a, b, t) => a + (b - a) * t;

    const SVG = {
        trash: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>',
        search: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        plus: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
        out: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
        up: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>',
        user: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        inbox: '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>'
    };

    /* ---------- Toast ---------- */
    function toast(msg, ms = 3200) {
        let host = $('#toastHost');
        if (!host) { host = document.createElement('div'); host.id = 'toastHost'; document.body.appendChild(host); }
        const t = document.createElement('div');
        t.className = 'toast-lite'; t.textContent = msg; host.appendChild(t);
        setTimeout(() => { t.classList.add('out'); setTimeout(() => t.remove(), 300); }, ms);
    }
    window.ServiceUI = { toast };

    /* ---------- Progress: navigasi + scroll ---------- */
    safe('progress', () => {
        const nav = document.createElement('div'); nav.id = 'navProgress';
        const sp = document.createElement('div'); sp.id = 'scrollProgress';
        document.body.append(nav, sp);
        let timer;
        const start = () => {
            nav.style.opacity = 1; nav.style.width = '18%';
            clearInterval(timer);
            let w = 18;
            timer = setInterval(() => { w += (92 - w) * 0.08; nav.style.width = w + '%'; }, 180);
        };
        document.addEventListener('click', e => {
            const a = e.target.closest('a[href]');
            if (!a || a.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
            const h = a.getAttribute('href');
            if (!h || h.startsWith('#') || h.startsWith('javascript') || a.hasAttribute('download')) return;
            if (a.origin !== location.origin) return;
            start();
        });
        document.addEventListener('submit', e => { if (!e.defaultPrevented) start(); });
        window.addEventListener('pageshow', () => { clearInterval(timer); nav.style.width = '0'; nav.style.opacity = 0; });

        const onScroll = () => {
            const max = document.documentElement.scrollHeight - innerHeight;
            const p = max > 0 ? Math.min(1, scrollY / max) : 0;
            sp.style.transform = 'scaleX(' + p + ')';
            const tt = $('#toTop');
            if (tt) { tt.classList.toggle('show', scrollY > 420); tt.style.setProperty('--p', p.toFixed(3)); }
        };
        addEventListener('scroll', onScroll, { passive: true }); onScroll();
    });

    /* ---------- Latar aurora (layout utama) ---------- */
    safe('aurora', () => {
        if (reduceMotion || !$('.app-main')) return;
        const a = document.createElement('div'); a.className = 'aurora';
        a.innerHTML = '<i></i><i></i><i></i>'; document.body.prepend(a);
    });

    /* ---------- Kursor animasi ---------- */
    safe('cursor', () => {
        if (!finePointer || reduceMotion) return;
        const dot = document.createElement('div'); dot.className = 'cursor-dot';
        const ring = document.createElement('div'); ring.className = 'cursor-ring';
        const glow = document.createElement('div'); glow.className = 'cursor-glow';
        document.body.append(glow, ring, dot);
        const root = document.documentElement;
        let mx = innerWidth / 2, my = innerHeight / 2, rx = mx, ry = my, gx = mx, gy = my, started = false;

        addEventListener('mousemove', e => {
            mx = e.clientX; my = e.clientY;
            if (!started) { started = true; rx = gx = mx; ry = gy = my; root.classList.add('has-custom-cursor', 'cursor-ready'); }
            dot.style.transform = `translate3d(${mx}px,${my}px,0)`;
        }, { passive: true });
        (function loop() {
            rx = lerp(rx, mx, 0.18); ry = lerp(ry, my, 0.18);
            gx = lerp(gx, mx, 0.07); gy = lerp(gy, my, 0.07);
            ring.style.transform = `translate3d(${rx}px,${ry}px,0)`;
            glow.style.transform = `translate3d(${gx}px,${gy}px,0)`;
            requestAnimationFrame(loop);
        })();

        const HOVER = 'a, button, [role="button"], select, label, summary, .btn, .sidebar-link, .kpi-cell, .cmdk-item, th.sortable, input[type="radio"], input[type="checkbox"], input[type="file"]';
        const TEXT = 'input:not([type="radio"]):not([type="checkbox"]):not([type="file"]):not([type="submit"]), textarea';
        const DANGER = '.btn-danger, .btn-danger-solid';
        document.addEventListener('mouseover', e => {
            const t = e.target;
            root.classList.toggle('cursor-text', !!t.closest(TEXT));
            root.classList.toggle('cursor-hover', !t.closest(TEXT) && !!t.closest(HOVER));
            root.classList.toggle('cursor-danger', !!t.closest(DANGER));
        });
        document.addEventListener('mousedown', e => {
            root.classList.add('cursor-down');
            const b = document.createElement('div'); b.className = 'click-burst';
            b.style.left = e.clientX + 'px'; b.style.top = e.clientY + 'px';
            document.body.appendChild(b); setTimeout(() => b.remove(), 650);
        });
        document.addEventListener('mouseup', () => root.classList.remove('cursor-down'));
        document.addEventListener('mouseleave', () => root.classList.remove('cursor-ready'));
        document.addEventListener('mouseenter', () => started && root.classList.add('cursor-ready'));
    });

    /* ---------- Spotlight, tilt, magnetic ---------- */
    safe('pointer-fx', () => {
        if (!finePointer) return;
        const SPOT = '.card, .editor-card, .kpi-cell, .sidebar-link, .login-card, .module-panel';
        document.addEventListener('mousemove', e => {
            const el = e.target.closest && e.target.closest(SPOT);
            if (!el) return;
            const r = el.getBoundingClientRect();
            el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            el.style.setProperty('--my', (e.clientY - r.top) + 'px');
        }, { passive: true });

        if (reduceMotion) return;
        $$('.login-card, .module-panel').forEach(card => {
            card.addEventListener('mousemove', e => {
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = `perspective(900px) rotateX(${(-y * 5).toFixed(2)}deg) rotateY(${(x * 6).toFixed(2)}deg)`;
            });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });

        $$('.btn-primary, .btn-accent, .login-button').forEach(btn => {
            btn.addEventListener('mousemove', e => {
                const r = btn.getBoundingClientRect();
                const x = (e.clientX - r.left - r.width / 2) * 0.18, y = (e.clientY - r.top - r.height / 2) * 0.28;
                btn.style.transform = `translate(${x}px,${y}px)`;
            });
            btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
        });
    });

    /* ---------- Ripple tombol ---------- */
    safe('ripple', () => {
        document.addEventListener('click', e => {
            const b = e.target.closest('.btn, .btn-accent, .btn-ghost, .login-button');
            if (!b) return;
            const r = b.getBoundingClientRect(), s = Math.max(r.width, r.height);
            const el = document.createElement('span'); el.className = 'ripple';
            el.style.cssText = `width:${s}px;height:${s}px;left:${e.clientX - r.left - s / 2}px;top:${e.clientY - r.top - s / 2}px`;
            b.appendChild(el); setTimeout(() => el.remove(), 650);
        });
    });

    /* ---------- Reveal saat scroll ---------- */
    safe('reveal', () => {
        const targets = $$('.card, .kpi-cell, .composition, .editor-card, .table-toolbar');
        targets.forEach((el, i) => { if (!el.hasAttribute('data-reveal')) { el.setAttribute('data-reveal', ''); el.style.setProperty('--d', Math.min(i, 8) * 70 + 'ms'); } });
        if (!('IntersectionObserver' in window)) { targets.forEach(el => el.classList.add('is-in')); return; }
        const io = new IntersectionObserver(es => es.forEach(en => {
            if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
        }), { threshold: 0.08 });
        $$('[data-reveal]').forEach(el => io.observe(el));
    });

    /* ---------- Sidebar: collapse, tooltip, mobile ---------- */
    safe('sidebar', () => {
        $$('.sidebar-link').forEach(a => {
            const label = a.querySelector('span');
            if (label && !a.querySelector('.nav-tip')) {
                const tip = document.createElement('span'); tip.className = 'nav-tip'; tip.textContent = label.textContent.trim(); a.appendChild(tip);
            }
        });
        const pill = $('.user-pill');
        if (pill) pill.dataset.initial = (pill.textContent.trim()[0] || '?').toUpperCase();

        const btn = $('#sidebarCollapse');
        btn?.addEventListener('click', () => {
            const on = document.body.classList.toggle('sidebar-collapsed');
            try { localStorage.setItem('sm.sidebar', on ? '1' : '0'); } catch (e) {}
        });
        addEventListener('keydown', e => {
            if (e.key === 'Escape') $('#sidebarClose')?.click();
        });
    });

    /* ---------- Jam langsung ---------- */
    safe('clock', () => {
        const el = $('#liveClock'); if (!el) return;
        const tick = () => {
            el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(/\./g, ':');
        };
        tick(); setInterval(tick, 1000);
    });

    /* ---------- Count-up KPI + bar komposisi ---------- */
    safe('counters', () => {
        const run = el => {
            const end = parseInt(el.dataset.count ?? el.textContent.replace(/\D/g, ''), 10);
            if (isNaN(end)) return;
            if (reduceMotion || end === 0) { el.textContent = end.toLocaleString('id-ID'); return; }
            const dur = 1100, t0 = performance.now();
            const step = now => {
                const p = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - p, 4);
                el.textContent = Math.round(end * e).toLocaleString('id-ID');
                if (p < 1) requestAnimationFrame(step);
            };
            el.textContent = '0'; requestAnimationFrame(step);
        };
        $$('.kpi-value').forEach(el => { el.dataset.count = el.textContent.replace(/\D/g, ''); });
        const io = 'IntersectionObserver' in window ? new IntersectionObserver(es => es.forEach(en => {
            if (!en.isIntersecting) return;
            const v = en.target.querySelector('.kpi-value'); if (v) run(v);
            const bar = en.target.querySelector('.kpi-bar span'); if (bar) bar.style.width = bar.dataset.pct + '%';
            io.unobserve(en.target);
        }), { threshold: 0.4 }) : null;
        $$('.kpi-cell').forEach(c => io ? io.observe(c) : run(c.querySelector('.kpi-value')));

        $$('.composition-bar span').forEach(s => setTimeout(() => { s.style.flexBasis = s.dataset.pct + '%'; }, 350));
    });

    /* ---------- Tabel: stagger, sort, pencarian pintar ---------- */
    safe('tables', () => {
        $$('.table').forEach(table => {
            const tbody = table.tBodies[0]; if (!tbody) return;
            const dataRows = () => $$('tr', tbody).filter(r => !r.querySelector('.empty-state') && !r.classList.contains('no-result-row'));
            dataRows().forEach((r, i) => { r.classList.add('row-in'); r.style.setProperty('--d', Math.min(i, 14) * 35 + 'ms'); });

            // ikon pada empty-state bawaan
            const es = tbody.querySelector('td.empty-state');
            if (es && !es.querySelector('svg')) es.insertAdjacentHTML('afterbegin', SVG.inbox + '<br>');

            // sortable
            const ths = $$('thead th', table);
            ths.forEach((th, idx) => {
                const txt = th.textContent.trim().toLowerCase();
                if (!txt || txt === 'aksi' || txt === 'foto') return;
                th.classList.add('sortable');
                th.addEventListener('click', () => {
                    const asc = !th.classList.contains('sort-asc');
                    ths.forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
                    th.classList.add(asc ? 'sort-asc' : 'sort-desc');
                    const val = r => {
                        const t = (r.cells[idx]?.textContent || '').trim();
                        const d = t.match(/^(\d{2})-(\d{2})-(\d{4})$/); if (d) return +(d[3] + d[2] + d[1]);
                        if (/^(Rp\s*)?#?[\d.,]+$/.test(t)) return parseFloat(t.replace(/[^\d,]/g, '').replace(',', '.'));
                        return t.toLowerCase();
                    };
                    const rows = dataRows().sort((a, b) => {
                        const x = val(a), y = val(b);
                        const c = (typeof x === 'number' && typeof y === 'number') ? x - y : String(x).localeCompare(String(y), 'id', { numeric: true });
                        return asc ? c : -c;
                    });
                    rows.forEach((r, i) => { r.classList.remove('row-in'); tbody.appendChild(r); r.style.setProperty('--d', Math.min(i, 14) * 25 + 'ms'); void r.offsetWidth; r.classList.add('row-in'); });
                    const nrow = $('.no-result-row', tbody); if (nrow) tbody.appendChild(nrow);
                });
            });

            // pencarian: highlight + counter + "tidak ada hasil"
            const card = table.closest('.card');
            const input = card && $('#tableSearch', card);
            if (!input) return;
            const counter = $('.data-counter strong', card);
            const total = dataRows().length;
            let nr = null;
            const clearMarks = () => $$('mark.hl', tbody).forEach(m => { const p = m.parentNode; p.replaceChild(document.createTextNode(m.textContent), m); p.normalize(); });
            const mark = (root, kw) => {
                const w = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, { acceptNode: n => n.parentElement.closest('button, form, a.btn, script, style') ? NodeFilter.FILTER_REJECT : (n.nodeValue.toLowerCase().includes(kw) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT) });
                const nodes = []; while (w.nextNode()) nodes.push(w.currentNode);
                nodes.forEach(n => {
                    const i = n.nodeValue.toLowerCase().indexOf(kw); if (i < 0) return;
                    const m = document.createElement('mark'); m.className = 'hl';
                    const mid = n.splitText(i); mid.splitText(kw.length);
                    m.textContent = mid.nodeValue; mid.parentNode.replaceChild(m, mid);
                });
            };
            input.addEventListener('input', () => {
                const kw = input.value.trim().toLowerCase();
                clearMarks();
                let shown = 0;
                dataRows().forEach(r => {
                    const ok = !kw || r.textContent.toLowerCase().includes(kw);
                    r.style.display = ok ? '' : 'none';
                    if (ok) { shown++; if (kw) mark(r, kw); }
                });
                if (counter) counter.textContent = kw ? shown + ' / ' + total : total;
                if (total > 0 && shown === 0) {
                    if (!nr) {
                        nr = document.createElement('tr'); nr.className = 'no-result-row';
                        nr.innerHTML = '<td class="empty-state" colspan="' + (ths.length || 1) + '">' + SVG.inbox + '<br>Tidak ada hasil untuk “<b class="text-white"></b>”.</td>';
                        tbody.appendChild(nr);
                    }
                    nr.querySelector('b').textContent = input.value.trim(); nr.style.display = '';
                } else if (nr) nr.style.display = 'none';
            });
            input.addEventListener('keydown', e => { if (e.key === 'Escape') { input.value = ''; input.dispatchEvent(new Event('input')); input.blur(); } });
        });

        addEventListener('keydown', e => {
            if (e.key === '/' && !/INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName)) {
                const s = $('#tableSearch'); if (s) { e.preventDefault(); s.focus(); }
            }
        });
        const s = $('#tableSearch'); if (s && finePointer) s.placeholder += '  ( tekan / )';
    });

    /* ---------- Modal konfirmasi hapus (ganti confirm() bawaan browser) ---------- */
    safe('confirm', () => {
        const bd = document.createElement('div'); bd.className = 'confirm-backdrop';
        bd.innerHTML = '<div class="confirm-box" role="alertdialog" aria-modal="true"><div class="confirm-icon">' + SVG.trash +
            '</div><h5>Hapus data ini?</h5><p>Tindakan ini tidak dapat dibatalkan.</p><div class="confirm-actions">' +
            '<button type="button" class="btn btn-secondary" data-no>Batal</button><button type="button" class="btn btn-danger-solid" data-yes>Ya, hapus</button></div></div>';
        document.body.appendChild(bd);
        let pending = null;
        const close = () => { bd.classList.remove('show'); pending = null; };
        const open = (form, msg) => { pending = form; $('h5', bd).textContent = msg; bd.classList.add('show'); $('[data-no]', bd).focus(); };
        bd.addEventListener('click', e => { if (e.target === bd || e.target.closest('[data-no]')) close(); });
        $('[data-yes]', bd).addEventListener('click', () => {
            const f = pending; if (!f) return;
            const b = $('[data-yes]', bd); b.classList.add('is-loading'); b.textContent = 'Menghapus';
            f.dataset.confirmed = '1'; f.submit();
        });
        addEventListener('keydown', e => { if (e.key === 'Escape' && bd.classList.contains('show')) close(); });
        document.addEventListener('submit', e => {
            const f = e.target;
            if (f.dataset.confirm && f.dataset.confirmed !== '1') { e.preventDefault(); e.stopImmediatePropagation(); open(f, f.dataset.confirm); }
        }, true);

        // dilakukan TERAKHIR: baru setelah modal siap, onclick confirm() bawaan dilepas
        $$('[onclick*="confirm("]').forEach(btn => {
            const m = btn.getAttribute('onclick').match(/confirm\((['"])(.*?)\1\)/);
            if (m && btn.form) { btn.form.dataset.confirm = m[2]; btn.removeAttribute('onclick'); }
        });
    });

    /* ---------- Command palette (Ctrl/⌘ + K) ---------- */
    safe('cmdk', () => {
        const items = [];
        $$('.sidebar-link').forEach(a => items.push({ g: 'Navigasi', t: a.textContent.replace(/\s+/g, ' ').trim().replace(/\s?\S*$/, m => m).trim(), href: a.href, icon: a.querySelector('svg')?.outerHTML || SVG.search }));
        // bersihkan label (hilangkan teks tooltip ganda)
        $$('.sidebar-link').forEach((a, i) => { const l = a.querySelector('span:not(.nav-tip)'); if (l) items[i].t = l.textContent.trim(); });
        $$('.quick-bar a').forEach(a => items.push({ g: 'Aksi cepat', t: 'Tambah ' + a.textContent.replace('+', '').trim(), href: a.href, icon: SVG.plus }));
        const prof = $('.user-pill[href]'); if (prof) items.push({ g: 'Akun', t: 'Profil saya', href: prof.href, icon: SVG.user });
        const logout = $('form[action*="logout"]'); if (logout) items.push({ g: 'Akun', t: 'Keluar (Logout)', run: () => logout.submit(), icon: SVG.out });
        items.push({ g: 'Lainnya', t: 'Kembali ke atas', run: () => scrollTo({ top: 0, behavior: 'smooth' }), icon: SVG.up });
        if (!items.length) return;

        const bd = document.createElement('div'); bd.className = 'cmdk-backdrop';
        bd.innerHTML = '<div class="cmdk"><div class="cmdk-input">' + SVG.search + '<input type="text" placeholder="Cari menu atau aksi…" autocomplete="off"><span class="kbd">Esc</span></div><div class="cmdk-list"></div><div class="cmdk-foot"><span>↑↓ pilih</span><span>↵ buka</span><span>Esc tutup</span></div></div>';
        document.body.appendChild(bd);
        const input = $('input', bd), list = $('.cmdk-list', bd);
        let view = [], sel = 0;

        const render = () => {
            const q = input.value.trim().toLowerCase();
            view = items.filter(i => !q || i.t.toLowerCase().includes(q) || i.g.toLowerCase().includes(q));
            sel = Math.min(sel, Math.max(0, view.length - 1));
            if (!view.length) { list.innerHTML = '<div class="cmdk-empty">Tidak ada hasil.</div>'; return; }
            let html = '', last = '';
            view.forEach((it, i) => {
                if (it.g !== last) { html += '<div class="cmdk-group">' + it.g + '</div>'; last = it.g; }
                html += '<a href="#" class="cmdk-item' + (i === sel ? ' sel' : '') + '" data-i="' + i + '">' + it.icon + '<span>' + it.t + '</span></a>';
            });
            list.innerHTML = html;
            $('.sel', list)?.scrollIntoView({ block: 'nearest' });
        };
        const go = i => { const it = view[i]; if (!it) return; close(); it.run ? it.run() : (location.href = it.href); };
        const open = () => { bd.classList.add('show'); input.value = ''; sel = 0; render(); setTimeout(() => input.focus(), 10); };
        const close = () => bd.classList.remove('show');

        input.addEventListener('input', () => { sel = 0; render(); });
        list.addEventListener('click', e => { const a = e.target.closest('.cmdk-item'); if (a) { e.preventDefault(); go(+a.dataset.i); } });
        list.addEventListener('mousemove', e => { const a = e.target.closest('.cmdk-item'); if (a && +a.dataset.i !== sel) { sel = +a.dataset.i; $$('.cmdk-item', list).forEach(x => x.classList.toggle('sel', +x.dataset.i === sel)); } });
        bd.addEventListener('click', e => { if (e.target === bd) close(); });
        input.addEventListener('keydown', e => {
            if (e.key === 'ArrowDown') { e.preventDefault(); sel = (sel + 1) % view.length; render(); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); sel = (sel - 1 + view.length) % view.length; render(); }
            else if (e.key === 'Enter') { e.preventDefault(); go(sel); }
            else if (e.key === 'Escape') close();
        });
        addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); bd.classList.contains('show') ? close() : open(); }
        });
        $$('[data-open-cmdk]').forEach(b => b.addEventListener('click', open));
    });

    /* ---------- Back to top ---------- */
    safe('totop', () => {
        if (!$('.app-main')) return;
        const b = document.createElement('button'); b.id = 'toTop'; b.setAttribute('aria-label', 'Kembali ke atas'); b.type = 'button';
        b.innerHTML = '<svg viewBox="0 0 44 44"><circle cx="22" cy="22" r="20"/></svg>' + SVG.up.replace('<svg', '<svg style="position:relative;width:16px;height:16px"');
        b.addEventListener('click', () => scrollTo({ top: 0, behavior: 'smooth' }));
        document.body.appendChild(b);
        dispatchEvent(new Event('scroll'));
    });

    /* ---------- Form: UX tambahan (tanpa mengubah nilai yang dikirim) ---------- */
    safe('forms', () => {
        // tombol simpan: indikator loading (handler bawaan tetap berjalan)
        $$('form').forEach(f => f.addEventListener('submit', () => {
            if (f.dataset.confirm) return;
            const b = $('button[type="submit"].btn-primary', f); if (b) b.classList.add('is-loading');
        }));

        // fokus ke field error pertama
        const bad = $('.is-invalid, .border-danger');
        if (bad) setTimeout(() => { bad.scrollIntoView({ behavior: 'smooth', block: 'center' }); bad.focus?.({ preventScroll: true }); }, 350);

        // pratinjau rupiah (hanya tampilan)
        $$('input[type="number"][name*="biaya"], input[type="number"][name*="harga"], input[type="number"][name*="nominal"]').forEach(inp => {
            const h = document.createElement('div'); h.className = 'money-hint'; inp.insertAdjacentElement('afterend', h);
            const upd = () => { h.textContent = inp.value !== '' ? 'Terbaca: Rp ' + Number(inp.value).toLocaleString('id-ID') : ''; };
            inp.addEventListener('input', upd); upd();
        });

        // penghitung karakter untuk textarea ber-maxlength
        $$('textarea[maxlength]').forEach(t => {
            const c = document.createElement('div'); c.className = 'char-count'; t.insertAdjacentElement('afterend', c);
            const upd = () => { c.textContent = t.value.length + ' / ' + t.maxLength; }; t.addEventListener('input', upd); upd();
        });

        // pratinjau foto + drag & drop
        const file = $('input[type="file"][accept*="image"]');
        if (file) {
            const pv = document.createElement('div'); pv.className = 'file-preview';
            pv.innerHTML = '<img alt="Pratinjau"><div><strong class="text-white"></strong><small></small></div>';
            file.insertAdjacentElement('afterend', pv);
            const show = () => {
                const f = file.files[0]; if (!f) { pv.classList.remove('show'); return; }
                $('img', pv).src = URL.createObjectURL(f);
                $('strong', pv).textContent = f.name; $('small', pv).textContent = (f.size / 1024).toFixed(0) + ' KB';
                pv.classList.add('show');
            };
            file.addEventListener('change', show);
            ['dragenter', 'dragover'].forEach(ev => file.addEventListener(ev, () => file.classList.add('dropzone-active')));
            ['dragleave', 'drop'].forEach(ev => file.addEventListener(ev, () => file.classList.remove('dropzone-active')));
        }

        // auto-tutup alert sukses
        const ok = $('.alert-custom-success');
        if (ok) setTimeout(() => {
            ok.style.transition = 'all .5s ease'; ok.style.opacity = 0; ok.style.maxHeight = ok.offsetHeight + 'px';
            requestAnimationFrame(() => { ok.style.maxHeight = 0; ok.style.margin = 0; ok.style.padding = 0; });
            setTimeout(() => ok.remove(), 520);
        }, 5200);
    });

    /* ---------- Halaman auth: kekuatan password + caps lock ---------- */
    safe('auth', () => {
        const pw = $('#password'); if (!pw) return;
        const wrap = pw.closest('.password-container') || pw.parentElement;
        const caps = document.createElement('div'); caps.className = 'caps-warn'; caps.textContent = '⚠ Caps Lock sedang aktif';
        wrap.insertAdjacentElement('afterend', caps);
        pw.addEventListener('keyup', e => caps.classList.toggle('show', e.getModifierState && e.getModifierState('CapsLock')));
        pw.addEventListener('blur', () => caps.classList.remove('show'));

        if ($('#password_confirmation')) {
            const m = document.createElement('div'); m.className = 'pw-meter'; m.innerHTML = '<span></span>';
            const l = document.createElement('div'); l.className = 'pw-label';
            caps.insertAdjacentElement('afterend', m); m.insertAdjacentElement('afterend', l);
            const lv = [['', 0, '#52525b'], ['Lemah', 25, '#ef4444'], ['Cukup', 50, '#f59e0b'], ['Baik', 75, '#84cc16'], ['Kuat', 100, '#22c55e']];
            pw.addEventListener('input', () => {
                const v = pw.value; let s = 0;
                if (v.length >= 8) s++; if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++; if (/\d/.test(v)) s++; if (/[^A-Za-z0-9]/.test(v)) s++;
                if (!v) s = 0; const [t, w, c] = lv[s];
                const bar = $('span', m); bar.style.width = w + '%'; bar.style.background = c;
                l.textContent = t ? 'Kekuatan kata sandi: ' + t : ''; l.style.color = c;
            });
        }
    });

    /* ---------- Partikel (login, register, welcome, 404) ---------- */
    safe('particles', () => {
        if (reduceMotion || $('.app-main')) return;
        if (!$('.login-wrapper, .portal-main, .container, .auth-wrap, body')) return;
        const cv = document.createElement('canvas'); cv.className = 'fx-particles'; document.body.prepend(cv);
        const ctx = cv.getContext('2d'); let W, H, pts = [], mouse = { x: -999, y: -999 };
        const resize = () => {
            const dpr = Math.min(devicePixelRatio || 1, 2);
            W = cv.width = innerWidth * dpr; H = cv.height = innerHeight * dpr; cv.style.width = innerWidth + 'px'; cv.style.height = innerHeight + 'px'; ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            const n = Math.min(70, Math.floor(innerWidth * innerHeight / 22000));
            pts = Array.from({ length: n }, () => ({ x: Math.random() * innerWidth, y: Math.random() * innerHeight, vx: (Math.random() - .5) * .35, vy: (Math.random() - .5) * .35, r: Math.random() * 1.6 + .6 }));
        };
        resize(); addEventListener('resize', resize);
        addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; }, { passive: true });
        let run = true; document.addEventListener('visibilitychange', () => { run = !document.hidden; if (run) draw(); });
        function draw() {
            if (!run) return;
            ctx.clearRect(0, 0, innerWidth, innerHeight);
            for (const p of pts) {
                const dx = p.x - mouse.x, dy = p.y - mouse.y, d = Math.hypot(dx, dy);
                if (d < 120) { p.x += dx / d * 1.2; p.y += dy / d * 1.2; }
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > innerWidth) p.vx *= -1; if (p.y < 0 || p.y > innerHeight) p.vy *= -1;
                ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, 6.283); ctx.fillStyle = 'rgba(251,146,60,.65)'; ctx.fill();
            }
            for (let i = 0; i < pts.length; i++) for (let j = i + 1; j < pts.length; j++) {
                const a = pts[i], b = pts[j], d = Math.hypot(a.x - b.x, a.y - b.y);
                if (d < 120) { ctx.strokeStyle = 'rgba(234,88,12,' + (0.22 * (1 - d / 120)).toFixed(3) + ')'; ctx.lineWidth = 1; ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke(); }
            }
            requestAnimationFrame(draw);
        }
        draw();
    });

    /* ---------- Sapaan dashboard sesuai jam ---------- */
    safe('greeting', () => {
        const g = $('#greeting'); if (!g) return;
        const h = new Date().getHours();
        g.textContent = h < 11 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 18 ? 'Selamat sore' : 'Selamat malam';
    });
})();
