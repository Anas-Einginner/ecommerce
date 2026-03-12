@extends('ecommerce-project.master')
@section('content')
   <section class="presentation">
    <div class="container">
        <div class="presentation-header">
            <h1>Guardians of Palestinian Heritage</h1>
            <p>Women of different generations preserving identity through Tatreez.</p>
        </div>

        <div class="cards-grid">

            @foreach($heritages as $heritage)
                <div class="present-card">
                    <img src="{{ asset('storage/'.$heritage->image) }}" 
                         alt="{{ $heritage->title }}">

                    <div class="card-overlay">
                        <h3>{{ $heritage->title }}</h3>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">The Soul of Palestine</h2>
            <p class="section-subtitle">Stitched, Not Written</p>
            <p class="culture-text">
                Palestinian Tatreez is a living archive. Each stitch records memory,
                geography, and belonging — carried across generations of women.
            </p>
            <div class="quote">
                "Tatreez is not ornament — it is identity passed from mother to daughter."
            </div>
            <div class="arabic-text">
                التطريز الفلسطيني هو ذاكرة حيّة تحفظ الأرض والهوية عبر الأجيال.
            </div>
        </div>
    </section>

    <section class="premium-quote">
        <div class="container">
            <div class="quote-container">
                <div class="quote-icon">
                    <i class="fas fa-quote-left"></i>
                </div>
                <blockquote>
                    <p class="quote-text-large">
                        "Our hands remember what our minds may forget. In every stitch, every carving, every
                        brushstroke, we preserve not just art, but memory, identity, and home."
                    </p>
                </blockquote>
                <div class="quote-author">
                    <span class="author-name">— Um Mahmoud</span>
                    <span class="author-title">Master Embroidery Artisan</span>
                </div>
            </div>
        </div>
    </section>

   <section class="section">
    <div class="container">
        <h2 class="section-title">Meet Our Master Artisans</h2>
        <p class="section-subtitle">The Hands Behind The Heritage</p>

        <div class="artisans-grid">

            @foreach($artisans as $artisan)
                <div class="artisan-card">

                    <img 
                        src="{{ $artisan->image ? asset('storage/'.$artisan->image) : asset('img/default.png') }}" 
                        alt="{{ $artisan->name }}" 
                        class="artisan-img"
                    >

                    <div class="artisan-info">

                        <h3 class="artisan-name">
                            {{ $artisan->name }}
                        </h3>

                        <div class="artisan-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $artisan->location }}
                        </div>

                        <p class="artisan-bio">
                            {{ $artisan->bio }}
                        </p>

                        <div class="artisan-specialty">
                            <i class="fas fa-palette"></i>
                            Specialty: {{ $artisan->category->name ?? '-' }}
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

    <section class="cta">
        <h2>Be Part of the Story</h2>
        <p>Every purchase supports artisans and protects Palestinian heritage.</p>
    </section>

 

 @endsection