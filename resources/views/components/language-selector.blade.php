{{--
  Language Selector Component
  Dropdown to switch between available locales
--}}

@php
$i18nService = app(\App\Services\I18nService::class);
$availableLocales = $i18nService->getAvailableLocales();
$currentLocale = $i18nService->getLocale();

// Map locale codes to flag emojis and short codes
$localeInfo = [
    'en_US' => ['flag' => '🇺🇸', 'short' => 'EN'],
    'it_IT' => ['flag' => '🇮🇹', 'short' => 'IT'],
    'es_ES' => ['flag' => '🇪🇸', 'short' => 'ES'],
    'fr_FR' => ['flag' => '🇫🇷', 'short' => 'FR'],
    'de_DE' => ['flag' => '🇩🇪', 'short' => 'DE'],
    'pt_BR' => ['flag' => '🇧🇷', 'short' => 'PT'],
    'ja_JP' => ['flag' => '🇯🇵', 'short' => 'JA'],
    'zh_CN' => ['flag' => '🇨🇳', 'short' => 'ZH'],
    'ar' => ['flag' => '🇸🇦', 'short' => 'AR'],
    'he_IL' => ['flag' => '🇮🇱', 'short' => 'HE'],
    'fa_IR' => ['flag' => '🇮🇷', 'short' => 'FA'],
    'ur' => ['flag' => '🇵🇰', 'short' => 'UR'],
];

$currentInfo = $localeInfo[$currentLocale] ?? ['flag' => '🌐', 'short' => strtoupper(substr($currentLocale, 0, 2))];
@endphp

<div
  class="language-selector"
  x-data="{ open: false }"
  @click.away="open = false"
  @keydown.escape.window="open = false"
>
  {{-- Language Toggle Button --}}
  <button
    type="button"
    class="header-action-btn header-action-btn--language"
    @click="open = !open"
    :aria-expanded="open"
    aria-label="{{ __('Select language', 'sage') }}"
    aria-haspopup="true"
  >
    <svg class="header-action-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M1 10H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M10 1C11.6569 4.33331 11.6569 15.6667 10 19C8.34315 15.6667 8.34315 4.33331 10 1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="language-selector__current-code">{{ $currentInfo['short'] }}</span>
    <span class="sr-only">{{ __('Current language', 'sage') }}: {{ $availableLocales[$currentLocale] }}</span>
  </button>

  {{-- Language Dropdown --}}
  <div
    class="language-selector__dropdown"
    x-show="open"
    x-transition:enter="language-selector__dropdown--entering"
    x-transition:enter-start="language-selector__dropdown--enter-start"
    x-transition:enter-end="language-selector__dropdown--enter-end"
    x-transition:leave="language-selector__dropdown--leaving"
    x-transition:leave-start="language-selector__dropdown--leave-start"
    x-transition:leave-end="language-selector__dropdown--leave-end"
    x-cloak
    style="display: none;"
    role="menu"
  >
    <div class="language-selector__dropdown-header">
      <svg class="language-selector__dropdown-icon" width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M1 10H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M10 1C11.6569 4.33331 11.6569 15.6667 10 19C8.34315 15.6667 8.34315 4.33331 10 1Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="language-selector__dropdown-title">{{ __('Select Language', 'sage') }}</span>
    </div>

    <ul class="language-selector__list" role="listbox">
      @foreach($availableLocales as $localeCode => $localeName)
        @php
          $info = $localeInfo[$localeCode] ?? ['flag' => '🌐', 'short' => strtoupper(substr($localeCode, 0, 2))];
          $isCurrent = $localeCode === $currentLocale;
        @endphp

        <li role="presentation">
          <button
            type="button"
            class="language-selector__option {{ $isCurrent ? 'language-selector__option--active' : '' }}"
            data-locale="{{ $localeCode }}"
            @click="
              fetch('{{ admin_url('admin-ajax.php') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                  action: 'switch_locale',
                  locale: '{{ $localeCode }}',
                  nonce: '{{ wp_create_nonce('switch_locale_nonce') }}'
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  window.location.reload();
                }
              });
            "
            role="option"
            :aria-selected="{{ $isCurrent ? 'true' : 'false' }}"
          >
            <span class="language-selector__option-flag" aria-hidden="true">{{ $info['flag'] }}</span>
            <span class="language-selector__option-details">
              <span class="language-selector__option-name">{{ $localeName }}</span>
              <span class="language-selector__option-code">{{ $info['short'] }}</span>
            </span>
            @if($isCurrent)
              <svg class="language-selector__option-check" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.3333 4L6 11.3333L2.66667 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            @endif
          </button>
        </li>
      @endforeach
    </ul>
  </div>
</div>
