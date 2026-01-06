<section class="relative overflow-hidden w-full text-white">

    <div class="container mx-auto px-4 py-12 lg:py-12 relative z-10">


        <div class="relative">
            <div id="hero-track"
                class="relative min-h-[520px] rounded-3xl bg-white/5 border border-white/10 overflow-hidden shadow-2xl ">
                <!-- Slides injected by JS -->
            </div>

            <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-6 py-4">
                <div id="hero-dots" class="flex items-center gap-2"></div>
                <div class="flex items-center gap-3">
                    <button id="hero-prev" type="button" aria-label="Previous slide"
                        class="size-11 rounded-full bg-white/10 border border-white/20 text-white hover:bg-white/20 transition flex items-center justify-center backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button id="hero-next" type="button" aria-label="Next slide"
                        class="size-11 rounded-full bg-white/10 border border-white/20 text-white hover:bg-white/20 transition flex items-center justify-center backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="absolute inset-x-4 bottom-2 h-1.5 bg-white/10 rounded-full overflow-hidden mt-4">
                <div id="hero-progress" class="h-full w-0 bg-gradient-to-r from-blue-400 via-indigo-400 to-blue-600">
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = [{
                    eyebrow: 'Night Vision',
                    title: 'Illuminate every drive with adaptive ambient lighting',
                    copy: '',
                    cta: {
                        label: 'Shop Lighting',
                        href: '/shop'
                    },
                    secondary: {
                        label: 'See installs',
                        href: '/gallery'
                    },
                    stats: ['4.9/5 from 1,200+ installs', 'Lifetime beam warranty'],
                    image: 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80'
                },
                {
                    eyebrow: 'Performance Comfort',
                    title: 'Ride-ready interiors engineered for every season',
                    copy: '',
                    cta: {
                        label: 'Explore Interiors',
                        href: '/shop'
                    },
                    secondary: {
                        label: 'Build your set',
                        href: '/shop'
                    },
                    stats: ['52% less cabin heat', 'Designed for spill & snow'],
                    image: 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1600&q=80'
                },
                {
                    eyebrow: 'Cargo Control',
                    title: 'Modular storage systems for road trips and workdays',
                    copy: '',
                    cta: {
                        label: 'Shop Cargo',
                        href: '/shop'
                    },
                    secondary: {
                        label: 'Bundles & kits',
                        href: '/shop'
                    },
                    stats: ['+38% cargo efficiency', 'Tool-less install in 15 min'],
                    image: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1600&q=80'
                }
            ];

            const track = document.getElementById('hero-track');
            const dots = document.getElementById('hero-dots');
            const prevBtn = document.getElementById('hero-prev');
            const nextBtn = document.getElementById('hero-next');
            const progress = document.getElementById('hero-progress');

            if (!track || !dots || !prevBtn || !nextBtn || !progress) return;

            let current = 0;
            let timer;
            let rafId;
            let progressStart;

            const createSlideEl = (slide, index) => {
                const isFirst = index === 0;
                const wrapper = document.createElement('article');
                wrapper.className =
                    `absolute inset-0 transition-all duration-700 ease-out ${index === 0 ? 'opacity-100 scale-100' : 'opacity-0 scale-[0.98] pointer-events-none'}`;
                wrapper.dataset.heroSlide = index;
                wrapper.innerHTML = `
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/25 via-transparent to-indigo-500/10 blur-3xl"></div>
                <img data-lazy-src="${slide.image}" src="${isFirst ? slide.image : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=='}" alt="${slide.title}" loading="lazy" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            </div>
            <div class="relative h-full flex items-end">
                <div class="p-6 lg:p-10 space-y-6 max-w-4xl">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold tracking-wide uppercase text-blue-200 border border-white/10">${slide.eyebrow}</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight drop-shadow">${slide.title}</h2>
                    <p class="text-slate-200 text-lg leading-relaxed drop-shadow">${slide.copy}</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="${slide.cta.href}" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 hover:bg-blue-500 text-white px-6 h-12 font-semibold shadow-lg shadow-blue-600/30 transition">
                            ${slide.cta.label}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                        
                    </div>
                    <br>
                </div>
            </div>
        `;
                return wrapper;
            };

            const renderSlides = () => {
                track.innerHTML = '';
                slides.forEach((slide, idx) => track.appendChild(createSlideEl(slide, idx)));
            };

            const renderDots = () => {
                dots.innerHTML = '';
                slides.forEach((_, idx) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className =
                        `h-2 w-6 rounded-full transition-all duration-300 ${idx === current ? 'bg-white' : 'bg-white/30 hover:bg-white/60'}`;
                    btn.addEventListener('click', () => goTo(idx));
                    dots.appendChild(btn);
                });
            };

            const loadImage = (idx) => {
                const slideEl = track.querySelector(`[data-hero-slide="${idx}"]`);
                if (!slideEl) return;
                const img = slideEl.querySelector('img[data-lazy-src]');
                if (img && !img.dataset.loaded) {
                    img.src = img.dataset.lazySrc;
                    img.dataset.loaded = 'true';
                }
            };

            const updateSlides = () => {
                const slideEls = track.querySelectorAll('[data-hero-slide]');
                slideEls.forEach(el => {
                    const isActive = Number(el.dataset.heroSlide) === current;
                    el.classList.toggle('opacity-0', !isActive);
                    el.classList.toggle('scale-[0.98]', !isActive);
                    el.classList.toggle('pointer-events-none', !isActive);
                    el.classList.toggle('opacity-100', isActive);
                    el.classList.toggle('scale-100', isActive);
                });
                loadImage(current);
                renderDots();
            };

            const goTo = (idx) => {
                current = (idx + slides.length) % slides.length;
                updateSlides();
                restartProgress();
            };

            const next = () => goTo(current + 1);
            const prev = () => goTo(current - 1);

            const startTimer = () => {
                timer = setInterval(next, 6500);
            };

            const stopTimer = () => {
                if (timer) clearInterval(timer);
            };

            const animateProgress = (timestamp) => {
                if (!progressStart) progressStart = timestamp;
                const elapsed = timestamp - progressStart;
                const duration = 6500;
                const pct = Math.min(elapsed / duration, 1);
                progress.style.width = `${pct * 100}%`;
                if (pct >= 1) {
                    progressStart = null;
                    progress.style.width = '0%';
                } else {
                    rafId = requestAnimationFrame(animateProgress);
                }
            };

            const restartProgress = () => {
                progressStart = null;
                progress.style.width = '0%';
                if (rafId) cancelAnimationFrame(rafId);
                rafId = requestAnimationFrame(animateProgress);
                stopTimer();
                startTimer();
            };

            renderSlides();
            loadImage(0);
            updateSlides();
            startTimer();
            restartProgress();

            nextBtn.addEventListener('click', () => {
                next();
            });
            prevBtn.addEventListener('click', () => {
                prev();
            });

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopTimer();
                    if (rafId) cancelAnimationFrame(rafId);
                } else {
                    restartProgress();
                }
            });
        });
    </script>
@endpush
