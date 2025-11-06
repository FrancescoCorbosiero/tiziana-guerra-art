{{--
  Header Section
  Professional header with logo, navigation, search, and theme toggle
--}}

<header
  class="site-header"
  role="banner"
  x-data="{
    mobileMenuOpen: false,
    searchOpen: false,
    scrolled: false,
    init() {
      window.addEventListener('scroll', () => {
        this.scrolled = window.scrollY > 10;
      });
    }
  }"
  :class="{ 'site-header--scrolled': scrolled }"
>
  <div class="site-header__container">
    {{-- Logo --}}
    <div class="site-header__logo">
      <a href="{{ home_url('/') }}" class="logo" aria-label="{{ get_bloginfo('name') }} - Home">
        @if(has_custom_logo())
          {!! get_custom_logo() !!}
        @else
          <span class="logo__text">{{ get_bloginfo('name') }}</span>
        @endif
      </a>
    </div>

    {{-- Desktop Navigation --}}
    <nav class="site-header__nav" role="navigation" aria-label="Primary">
      @if(has_nav_menu('primary_navigation'))
        {!! wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'container' => false,
          'menu_class' => 'nav-menu',
          'fallback_cb' => false,
          'depth' => 2,
          'walker' => new \App\Helpers\NavWalker(),
          'echo' => false,
        ]) !!}
      @endif
    </nav>

    {{-- Header Actions --}}
    <div class="site-header__actions">
      {{-- Search Button --}}
      <button
        type="button"
        class="header-action-btn header-action-btn--search"
        @click="searchOpen = true"
        aria-label="Open search"
        aria-expanded="false"
      >
        <svg class="header-action-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M19 19L14.65 14.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sr-only">Search</span>
      </button>

      {{-- Language Selector --}}
      @include('components.language-selector')

      {{-- Theme Toggle --}}
      <button
        type="button"
        class="header-action-btn header-action-btn--theme"
        data-theme-toggle
        aria-label="Toggle dark mode"
      >
        <svg class="theme-toggle__icon theme-toggle__icon--light" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M10 1V3M10 17V19M19 10H17M3 10H1M16.364 16.364L14.95 14.95M14.95 5.05L16.364 3.636M3.636 16.364L5.05 14.95M5.05 5.05L3.636 3.636" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="10" cy="10" r="4" stroke="currentColor" stroke-width="2"/>
        </svg>
        <svg class="theme-toggle__icon theme-toggle__icon--dark" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19 10.79C18.8427 12.4922 18.2039 14.1144 17.1583 15.4668C16.1127 16.8192 14.7035 17.8458 13.0957 18.4265C11.4879 19.0073 9.74801 19.1181 8.07951 18.7461C6.41101 18.3741 4.88299 17.5345 3.67425 16.3258C2.46552 15.117 1.62596 13.589 1.25393 11.9205C0.881906 10.252 0.992717 8.51208 1.57347 6.9043C2.15423 5.29651 3.18085 3.88737 4.53323 2.84175C5.88562 1.79614 7.50782 1.15731 9.21 1C8.21207 2.34827 7.76245 4.00945 7.94091 5.66958C8.11937 7.32972 8.91506 8.86535 10.1849 9.9839C11.4547 11.1025 13.1062 11.7123 14.8017 11.6957C16.4972 11.6791 18.1358 11.0372 19.3839 10.89" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sr-only">Toggle theme</span>
      </button>

      {{-- Mobile Menu Toggle --}}
      <button
        type="button"
        class="header-action-btn header-action-btn--menu mobile-menu-toggle"
        @click="mobileMenuOpen = true"
        aria-label="Open menu"
        aria-expanded="false"
      >
        <svg class="header-action-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sr-only">Menu</span>
      </button>
    </div>
  </div>

  {{-- Mobile Menu Modal --}}
  <div
    class="mobile-menu-modal"
    x-show="mobileMenuOpen"
    x-transition:enter="mobile-menu-modal--entering"
    x-transition:enter-start="mobile-menu-modal--enter-start"
    x-transition:enter-end="mobile-menu-modal--enter-end"
    x-transition:leave="mobile-menu-modal--leaving"
    x-transition:leave-start="mobile-menu-modal--leave-start"
    x-transition:leave-end="mobile-menu-modal--leave-end"
    @click.self="mobileMenuOpen = false"
    x-cloak
    style="display: none;"
  >
    <div class="mobile-menu-modal__backdrop" @click="mobileMenuOpen = false"></div>

    <div class="mobile-menu-modal__dialog">
      {{-- Mobile Menu Header --}}
      <div class="mobile-menu__header">
        <div class="mobile-menu__logo">
          @if(has_custom_logo())
            {!! get_custom_logo() !!}
          @else
            <span class="logo__text">{{ get_bloginfo('name') }}</span>
          @endif
        </div>
        <button
          type="button"
          class="mobile-menu__close"
          @click="mobileMenuOpen = false"
          aria-label="Close menu"
        >
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>

      {{-- Mobile Menu Navigation --}}
      <nav class="mobile-menu__nav" role="navigation">
        @if(has_nav_menu('primary_navigation'))
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'container' => false,
            'menu_class' => 'mobile-nav-menu',
            'fallback_cb' => false,
            'depth' => 2,
            'walker' => new \App\Helpers\NavWalker(),
            'echo' => false,
          ]) !!}
        @endif
      </nav>

      {{-- Mobile Menu Footer --}}
      <div class="mobile-menu__footer">
        {{-- Language Selector in Mobile Menu --}}
        <div class="mobile-menu__language">
          @include('components.language-selector')
        </div>
        <p class="mobile-menu__footer-text">
          &copy; {{ date('Y') }} {{ get_bloginfo('name') }}
        </p>
      </div>
    </div>
  </div>

  {{-- Search Modal --}}
  <div
    class="search-modal"
    x-show="searchOpen"
    x-transition:enter="search-modal--entering"
    x-transition:enter-start="search-modal--enter-start"
    x-transition:enter-end="search-modal--enter-end"
    x-transition:leave="search-modal--leaving"
    x-transition:leave-start="search-modal--leave-start"
    x-transition:leave-end="search-modal--leave-end"
    @click.self="searchOpen = false"
    @keydown.escape.window="searchOpen = false"
    x-cloak
    style="display: none;"
  >
    <div class="search-modal__backdrop" @click="searchOpen = false"></div>

    <div class="search-modal__dialog">
      <button
        type="button"
        class="search-modal__close"
        @click="searchOpen = false"
        aria-label="Close search"
      >
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>

      <div class="search-modal__content">
        <form role="search" method="get" class="search-form" action="{{ home_url('/') }}">
          <div class="search-form__wrapper">
            <svg class="search-form__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <input
              type="search"
              class="search-form__input"
              placeholder="Search..."
              name="s"
              x-ref="searchInput"
              x-init="$watch('searchOpen', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 100) })"
            >
            <button type="submit" class="search-form__submit">
              Search
            </button>
          </div>
        </form>

        {{-- Search Suggestions (Optional) --}}
        <div class="search-suggestions">
          <p class="search-suggestions__title">Popular searches:</p>
          <div class="search-suggestions__tags">
            @php
              $popular_tags = get_tags(['number' => 5, 'orderby' => 'count', 'order' => 'DESC']);
            @endphp
            @foreach($popular_tags as $tag)
              <a href="{{ get_tag_link($tag->term_id) }}" class="search-suggestion-tag">
                {{ $tag->name }}
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
