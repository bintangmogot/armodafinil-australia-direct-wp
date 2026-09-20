<?php
/**
 * Single Medical Reviewer Template
 */
get_header(); 
?>

<main id="primary" class="site-main bg-white">
    <?php while ( have_posts() ) : the_post(); 
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/400x400/e0f2fe/0369a1?text=Doctor';
    ?>
    <article>
        <!-- Breadcrumb & Back Button -->
        <div class="border-b border-ink-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center justify-between text-xs text-ink-500">
                <div class="flex items-center gap-2">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
                    <span>/</span>
                    <span class="text-ink-900 truncate"><?php the_title(); ?></span>
                </div>
                <a href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : home_url( '/shop/' ) ); ?>" class="flex items-center gap-1.5 font-medium text-brand-700 hover:text-brand-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Go Back
                </a>
            </div>
        </div>
        
        <!-- Breadcrumb & Back Button -->
        

        <!-- Wash Header Profile -->
        <div class="section-wash border-b border-ink-200" style="padding-top: 5rem; padding-bottom: 5rem;">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-12">
                    
                    <!-- Fixed Size Avatar -->
                    <div class="w-48 h-48 md:w-56 md:h-56 flex-shrink-0 relative">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover rounded-3xl shadow-lg border-4 border-white bg-white" />
                        <div class="absolute -bottom-3 -right-3 bg-white p-2.5 rounded-full shadow-md border border-ink-100" title="Verified Medical Professional">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                    </div>

                    <!-- Header Info -->
                    <div class="flex-1 text-center md:text-left mt-2 md:mt-4">
                        <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100/50 rounded-full px-3 py-1.5 inline-block mb-3 border border-brand-200">
                            Medical Team
                        </div>
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-ink-900 leading-tight mb-2">
                            <?php the_title(); ?>
                        </h1>
                        <p class="text-xl text-ink-600 font-medium mb-6">
                            <?php echo esc_html(get_field('medical_title') ?: 'Physician'); ?>
                        </p>
                        
                        <div class="inline-flex items-center gap-2 text-sm text-teal-800 bg-teal-50 px-4 py-2 rounded-lg border border-teal-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                            <strong>Verified</strong> Medical Content Reviewer
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <!-- Bio Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-2xl p-8 sm:p-10 shadow-sm border border-ink-200">
                <h2 class="text-xl font-bold text-ink-900 mb-6 flex items-center gap-2 border-b border-ink-100 pb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    About <?php the_title(); ?>
                </h2>
                <div class="prose prose-ink prose-lg max-w-none text-ink-700 leading-relaxed">
                    <?php the_content(); ?>
                </div>

                <!-- Social Links -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-8 pt-6 border-t border-ink-100">
                    <span class="text-sm font-semibold text-ink-900">Connect with <?php the_title(); ?></span>
                    <div class="flex gap-2">
                        <a href="#" class="w-9 h-9 rounded-full border border-ink-200 bg-white flex items-center justify-center text-ink-600 hover:text-brand-700 hover:border-brand-300 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full border border-ink-200 bg-white flex items-center justify-center text-ink-600 hover:text-brand-700 hover:border-brand-300 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full border border-ink-200 bg-white flex items-center justify-center text-ink-600 hover:text-brand-700 hover:border-brand-300 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Stats Pills -->
                <div class="flex flex-wrap items-center gap-3 mt-6">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-ink-200 bg-white text-xs font-semibold text-ink-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        3 articles
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-ink-200 bg-white text-xs font-semibold text-ink-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        Latest <?php echo date('d M Y'); ?>
                    </span>
                </div>

                <div class="mt-12 pt-8 border-t border-ink-100 bg-slate-50 p-6 rounded-xl">
                    <div class="text-xs font-bold uppercase tracking-widest text-ink-500 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Medical Disclaimer
                    </div>
                    <p class="text-sm text-ink-600 italic leading-relaxed m-0">
                        <?php echo esc_html(get_the_title()); ?> serves strictly as an independent medical reviewer for educational purposes, ensuring clinical accuracy across Armodafinil Direct. This content does not constitute professional medical advice, diagnosis, or treatment.
                    </p>
                </div>
            </div>
        </div>

        <!-- Published Articles (Dummy Grid) -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-[11px] uppercase tracking-widest text-brand-700 font-bold bg-brand-50 rounded-full px-3 py-1.5 inline-block mb-4 border border-brand-100">
                Published Articles
            </div>
            <h2 class="text-3xl font-bold text-ink-900 mb-2">Articles by <?php the_title(); ?></h2>
            <p class="text-ink-600 mb-10">Browse the latest guidance and updates from this author.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dummy Article 1 -->
                <div class="group cursor-pointer">
                    <div class="rounded-2xl overflow-hidden mb-4 bg-slate-100 aspect-[3/2]">
                        <img src="https://placehold.co/600x400/e2e8f0/64748b?text=Kamagra+Oral+Jelly" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="flex gap-2 mb-3">
                        <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-1 rounded-full">erectile dysfunction</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-ink-500 mb-2">
                        <span><svg class="w-3 h-3 inline mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> 27 Aug 2026</span>
                        <span class="flex items-center gap-1.5"><img src="<?php echo esc_url($image); ?>" class="w-4 h-4 rounded-full" /> <span class="text-brand-700"><?php the_title(); ?></span></span>
                    </div>
                    <h3 class="text-lg font-bold text-ink-900 leading-tight group-hover:text-brand-700 transition-colors">Kamagra Oral Jelly: Flavours, How Sildenafil Works and What Australians Should Know</h3>
                </div>

                <!-- Dummy Article 2 -->
                <div class="group cursor-pointer">
                    <div class="rounded-2xl overflow-hidden mb-4 bg-slate-100 aspect-[3/2]">
                        <img src="https://placehold.co/600x400/e2e8f0/64748b?text=Dementia+VS+Enhancers" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="flex gap-2 mb-3">
                        <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Armodafinil</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-ink-500 mb-2">
                        <span><svg class="w-3 h-3 inline mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> 28 July 2026</span>
                        <span class="flex items-center gap-1.5"><img src="<?php echo esc_url($image); ?>" class="w-4 h-4 rounded-full" /> <span class="text-brand-700"><?php the_title(); ?></span></span>
                    </div>
                    <h3 class="text-lg font-bold text-ink-900 leading-tight group-hover:text-brand-700 transition-colors">What is dementia mean? Dementia VS Cognitive Enhancers</h3>
                </div>

                <!-- Dummy Article 3 -->
                <div class="group cursor-pointer">
                    <div class="rounded-2xl overflow-hidden mb-4 bg-slate-100 aspect-[3/2]">
                        <img src="https://placehold.co/600x400/e2e8f0/64748b?text=Armodafinil+Guide" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="flex gap-2 mb-3">
                        <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Armodafinil</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-ink-500 mb-2">
                        <span><svg class="w-3 h-3 inline mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> 17 June 2026</span>
                        <span class="flex items-center gap-1.5"><img src="<?php echo esc_url($image); ?>" class="w-4 h-4 rounded-full" /> <span class="text-brand-700"><?php the_title(); ?></span></span>
                    </div>
                    <h3 class="text-lg font-bold text-ink-900 leading-tight group-hover:text-brand-700 transition-colors">What Is Armodafinil? Everything You Need to Know Before Taking It</h3>
                </div>
            </div>
        </div>

        <!-- Call To Action Blocks -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- CTA Left -->
                <div class="lg:col-span-2 bg-gradient-to-br from-white to-[#f0fcf9] border border-[#ccf2eb] rounded-3xl p-8 sm:p-12 shadow-sm relative overflow-hidden">
                    <div class="text-[11px] uppercase tracking-widest text-teal-700 font-bold mb-4">GET STARTED</div>
                    <h2 class="text-3xl md:text-4xl font-bold text-ink-900 mb-4 font-serif leading-tight">Ready to order with confidence?</h2>
                    <p class="text-ink-600 text-lg mb-8 max-w-xl leading-relaxed">Pick your pack size, complete a secure checkout in minutes, and track your discreet parcel anywhere in Australia.</p>
                    
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="/shop/" class="inline-flex items-center justify-center bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-full px-8 py-3.5 transition-colors shadow-sm text-[15px]">
                            Order now
                            <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center bg-white border border-ink-200 hover:border-ink-300 hover:bg-slate-50 text-ink-900 font-medium rounded-full px-8 py-3.5 transition-colors shadow-sm text-[15px]">
                            How ordering works
                        </a>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-[13px] text-teal-800 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg> 
                            Verified pharmacy
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Secure checkout
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="13" x="4" y="5" rx="2"/><path d="M16 2v6"/><path d="M8 2v6"/><path d="M4 11h16"/></svg>
                            AU-wide delivery
                        </span>
                    </div>
                </div>

                <!-- CTA Right -->
                <div class="lg:col-span-1 bg-ink-900 rounded-3xl p-8 sm:p-12 shadow-sm flex flex-col justify-center border border-ink-800 relative overflow-hidden">
                    <div class="text-[11px] uppercase tracking-widest text-teal-400 font-bold mb-4">SPEAK WITH OUR TEAM</div>
                    <h3 class="text-3xl font-bold mb-4 font-serif text-white">Australia</h3>
                    <p class="text-slate-300 text-[15px] leading-relaxed mb-10">Product questions and delivery help &mdash; Mon-Fri, 9am&ndash;5pm AEST.</p>
                    
                    <div>
                        <a href="/contact/" class="inline-flex items-center justify-center bg-white text-ink-900 font-semibold rounded-full px-6 py-3.5 transition-colors hover:bg-slate-100 shadow-sm text-[14px]">
                            <svg class="mr-2.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                            Contact support
                        </a>
                    </div>
                </div>
                
            </div>
        </div>

    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>








