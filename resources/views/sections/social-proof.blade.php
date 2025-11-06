{{--
  Social Proof Section - Testimonials + Stats

  Split layout featuring:
  - Left: Key statistics (projects, satisfaction, delivery time)
  - Right: Featured testimonial with author info
--}}

<section class="social-proof" aria-label="Testimonianze e statistiche">
  <div class="social-proof__container">

    {{-- Stats Section (Left) --}}
    <div class="social-proof__stats" aria-label="Statistiche">
      <div class="stat" data-animate>
        <div class="stat__number" aria-label="Oltre 50">50+</div>
        <div class="stat__label">Progetti completati</div>
      </div>

      <div class="stat" data-animate>
        <div class="stat__number" aria-label="95 percento">95%</div>
        <div class="stat__label">Clienti soddisfatti</div>
      </div>

      <div class="stat" data-animate>
        <div class="stat__number" aria-label="Meno di 1 settimana">&lt;1 settimana</div>
        <div class="stat__label">Tempo medio consegna</div>
      </div>
    </div>

    {{-- Testimonial Section (Right) --}}
    <div class="social-proof__testimonial" data-animate>
      <blockquote>
        <p class="testimonial__quote">
          Finalmente qualcuno che parla chiaro. Prezzi onesti, lavoro pulito.
        </p>
        <footer class="testimonial__author">
          <div class="testimonial__avatar" aria-hidden="true">M</div>
          <div class="testimonial__info">
            <cite class="testimonial__name">Mario</cite>
            <span class="testimonial__role">Fotografo</span>
          </div>
        </footer>
      </blockquote>
    </div>

  </div>
</section>

{{--
  Note: Scroll animation trigger handled by JavaScript
  See resources/js/core/animations.js for IntersectionObserver implementation
--}}
