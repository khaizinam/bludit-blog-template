<?php

// Prepare data for server-side rendering
// Use the $content variable which Bludit already prepared for the current page
$allPages = array_values($content);

// Sticky pages helper
$stickyPages = [];
foreach ($pages->db as $key => $fields) {
    if ($fields['type'] === 'sticky') {
        $p = new Page($key);
        $stickyPages[] = $p;
    }
}
?>

<div class="space-y-12">
    <!-- SECTION 1 — BREAKING BAR "CHÚ Ý" -->
    <div class="w-full bg-slate-100 dark:bg-slate-900 border-y border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 overflow-hidden mb-8 text-sm">
        <div class="container mx-auto max-w-7xl flex items-center">
            <div class="bg-primary-600 text-white px-4 py-2 font-black uppercase tracking-widest shrink-0 z-10 flex items-center justify-center h-full text-xs shadow-[2px_0_5px_rgba(0,0,0,0.1)]">
                CHÚ Ý
            </div>
            <div class="flex-grow py-2 pl-4">
                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" class="font-medium">
                    <?php if (empty($stickyPages)): ?>
                        Chào mừng bạn đến với <?php echo $site->title(); ?> · Chúc bạn một ngày tốt lành · 
                    <?php else: ?>
                        <?php foreach ($stickyPages as $sp): ?>
                            <a href="<?php echo $sp->permalink(); ?>" class="hover:underline transition-all">
                                <?php echo $sp->title(); ?>
                            </a>
                            <span class="mx-6 text-slate-300 dark:text-slate-700">·</span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </marquee>
            </div>
        </div>
    </div>

    <!-- SECTION 2 — HERO / TIN NỔI BẬT -->
    <section class="container mx-auto max-w-7xl px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Featured Column (60%) -->
            <div class="lg:w-3/5">
                <?php if (isset($allPages[0])): $p0 = $allPages[0]; ?>
                <article class="group">
                    <a href="<?php echo $p0->permalink(); ?>" class="block overflow-hidden rounded-2xl mb-6 shadow-xl relative">
                        <img src="<?php echo $p0->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>" alt="<?php echo $p0->title(); ?>" onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';" class="w-full h-[380px] object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-red-600 text-white text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                                <?php echo $p0->category(); ?>
                            </span>
                        </div>
                    </a>
                    <div class="space-y-4">
                        <h2 class="text-3xl lg:text-4xl font-black leading-tight tracking-tighter dark:text-white group-hover:text-red-600 transition-colors">
                            <a href="<?php echo $p0->permalink(); ?>"><?php echo $p0->title(); ?></a>
                        </h2>
                        <div class="flex items-center text-xs text-gray-400 font-bold uppercase tracking-widest">
                            <time datetime="<?php echo $p0->dateRaw('c'); ?>"><?php echo $p0->date(); ?></time>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3 text-lg">
                            <?php echo $p0->description(); ?>
                        </p>
                    </div>
                </article>
                <?php endif; ?>
            </div>

            <!-- List Column (40%) -->
            <div class="lg:w-2/5 space-y-6">
                <?php for($i=1; $i<=3; $i++): if(isset($allPages[$i])): $pi = $allPages[$i]; ?>
                <article class="flex gap-4 pb-6 border-b border-gray-100 dark:border-gray-800 last:border-0 group">
                    <a href="<?php echo $pi->permalink(); ?>" class="shrink-0 rounded-lg overflow-hidden w-[100px] h-[68px] shadow-md">
                        <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>" alt="<?php echo $pi->title(); ?>" onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';" class="w-full h-full object-cover">
                    </a>
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-red-600 uppercase tracking-widest"><?php echo $pi->category(); ?></span>
                        <h3 class="text-base font-bold dark:text-gray-100 leading-snug line-clamp-2 group-hover:text-red-600 transition-colors">
                            <a href="<?php echo $pi->permalink(); ?>"><?php echo $pi->title(); ?></a>
                        </h3>
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            <?php echo $pi->date(); ?>
                        </div>
                    </div>
                </article>
                <?php endif; endfor; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 3 — MỚI NHẤT (6 bài, offset 0) -->
    <section class="container mx-auto max-w-7xl px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-black uppercase tracking-tighter border-l-8 border-red-600 pl-4 py-1 dark:text-white">
                Mới nhất
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php for($i=0; $i<6; $i++): if(isset($allPages[$i])): $pi = $allPages[$i]; ?>
            <article class="bg-white dark:bg-gray-900 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <a href="<?php echo $pi->permalink(); ?>" class="block h-[180px] overflow-hidden">
                    <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>" alt="<?php echo $pi->title(); ?>" onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </a>
                <div class="p-6 space-y-3">
                    <span class="text-[10px] font-black text-red-600 uppercase tracking-widest"><?php echo $pi->category(); ?></span>
                    <h3 class="text-lg font-extrabold dark:text-white leading-tight line-clamp-2 group-hover:text-red-600 transition-colors">
                        <a href="<?php echo $pi->permalink(); ?>"><?php echo $pi->title(); ?></a>
                    </h3>
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        <?php echo $pi->date(); ?>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                        <?php echo $pi->description(); ?>
                    </p>
                </div>
            </article>
            <?php endif; endfor; ?>
        </div>
    </section>

    <!-- SECTION 4 — DANH SÁCH BÀI VIẾT (list + xem thêm) -->
    <section class="container mx-auto max-w-7xl px-4 py-8 bg-gray-50/50 dark:bg-transparent rounded-3xl">
        <div class="mb-12">
            <h2 class="text-2xl font-black uppercase tracking-tighter border-l-8 border-red-600 pl-4 py-1 dark:text-white">
                Tất cả bài viết
            </h2>
        </div>

        <div id="article-list" class="space-y-2 mb-12">
            <?php 
            // Render server-side: bài thứ 7 đến 14 (offset 6, limit 8)
            $start = 6;
            $limit = 8;
            for($i=$start; $i<($start+$limit); $i++): 
                if(isset($allPages[$i])): $pi = $allPages[$i]; 
            ?>
            <div class="flex gap-6 py-6 border-b border-gray-100 dark:border-gray-800 last:border-0 group items-center">
                <a href="<?php echo $pi->permalink(); ?>" class="shrink-0 w-[130px] h-[85px] rounded-xl overflow-hidden shadow-lg">
                    <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>" alt="<?php echo $pi->title(); ?>" onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </a>
                <div class="flex-grow space-y-2">
                    <h3 class="text-lg font-bold dark:text-white leading-snug group-hover:text-red-600 transition-colors">
                        <a href="<?php echo $pi->permalink(); ?>"><?php echo $pi->title(); ?></a>
                    </h3>
                    <div class="flex items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        <?php echo $pi->date(); ?>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1 hidden md:block">
                        <?php echo $pi->description(); ?>
                    </p>
                </div>
            </div>
            <?php endif; endfor; ?>
        </div>

        <div x-data="articleLoader" class="text-center pb-12">
            
            <button @click="loadMore" 
                    x-show="!done" 
                    :disabled="loading"
                    class="px-10 py-4 border-2 border-red-600 text-red-600 font-black uppercase tracking-widest rounded-full hover:bg-red-600 hover:text-white transition-all duration-300 disabled:opacity-50 flex items-center mx-auto space-x-3 group">
                <span x-show="!loading">Xem thêm bài viết</span>
                <span x-show="loading" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Đang tải...
                </span>
                <svg x-show="!loading" class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="done" class="text-gray-400 font-bold uppercase tracking-widest py-4 bg-gray-100 dark:bg-gray-900 rounded-2xl">
                Bạn đã xem hết tất cả bài viết
            </div>
        </div>
    </section>

    <!-- SECTION 5 — PAGINATION FALLBACK -->
    <?php if (Paginator::numberOfPages() > 1): ?>
    <section class="container mx-auto max-w-7xl px-4 py-12 border-t border-gray-100 dark:border-gray-800">
        <nav class="flex items-center justify-between">
            <div>
                <?php if (Paginator::showPrev()): ?>
                <a href="<?php echo Paginator::previousPageUrl(); ?>" class="flex items-center space-x-3 text-sm font-black uppercase tracking-widest text-gray-500 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    <span>Trang trước</span>
                </a>
                <?php endif; ?>
            </div>
            <div class="text-xs font-bold text-gray-300 uppercase tracking-widest">
                Trang <?php echo Paginator::currentPage(); ?> / <?php echo Paginator::numberOfPages(); ?>
            </div>
            <div>
                <?php if (Paginator::showNext()): ?>
                <a href="<?php echo Paginator::nextPageUrl(); ?>" class="flex items-center space-x-3 text-sm font-black uppercase tracking-widest text-gray-500 hover:text-red-600 transition-colors group">
                    <span>Trang tiếp</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <?php endif; ?>
            </div>
        </nav>
    </section>
    <?php endif; ?>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('articleLoader', () => ({
        offset: 14, 
        loading: false, 
        done: false,
        async loadMore() {
            if (this.loading || this.done) return;
            this.loading = true;
            try {
                const res = await fetch(`?ajax=1&offset=${this.offset}`);
                if (!res.ok) throw new Error('Network response was not ok');
                const data = await res.json();
                
                if (data.length === 0) {
                    this.done = true;
                } else {
                    const list = document.getElementById('article-list');
                    data.forEach(item => {
                        const html = `
                            <div class="flex gap-6 py-6 border-b border-gray-100 dark:border-gray-800 last:border-0 group items-center animate-fade-in">
                                <a href="${item.permalink}" class="shrink-0 w-[130px] h-[85px] rounded-xl overflow-hidden shadow-lg">
                                    <img src="${item.coverImage}" onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </a>
                                <div class="flex-grow space-y-2">
                                    <h3 class="text-lg font-bold dark:text-white leading-snug group-hover:text-red-600 transition-colors">
                                        <a href="${item.permalink}">${item.title}</a>
                                    </h3>
                                    <div class="flex items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        ${item.date}
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1 hidden md:block">
                                        ${item.description}
                                    </p>
                                </div>
                            </div>
                        `;
                        list.insertAdjacentHTML('beforeend', html);
                    });
                    this.offset += data.length;
                    if (data.length < 8) this.done = true;
                }
            } catch (e) {
                console.error('Lỗi khi tải bài viết:', e);
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.5s ease-out forwards;
}
</style>
