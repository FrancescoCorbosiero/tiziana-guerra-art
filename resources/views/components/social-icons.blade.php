@props([
    'position' => 'inline', // inline, fixed-left, fixed-right, fixed-bottom
    'platforms' => [], // Array of social platforms
    'size' => 'base', // sm, base, lg
    'variant' => 'default', // default, minimal, filled, outlined
    'animated' => true,
    'orientation' => 'vertical', // vertical, horizontal (for fixed positions)
])

@php
$classes = 'social-icons';
$classes .= ' social-icons--' . $position;
$classes .= ' social-icons--' . $size;
$classes .= ' social-icons--' . $variant;
$classes .= ' social-icons--' . $orientation;

if ($animated) {
    $classes .= ' social-icons--animated';
}

// Platform icon SVGs and URLs
$platformData = [
    'github' => [
        'url' => 'https://github.com/',
        'label' => 'GitHub',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>'
    ],
    'twitter' => [
        'url' => 'https://twitter.com/',
        'label' => 'Twitter',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>'
    ],
    'linkedin' => [
        'url' => 'https://linkedin.com/in/',
        'label' => 'LinkedIn',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>'
    ],
    'dribbble' => [
        'url' => 'https://dribbble.com/',
        'label' => 'Dribbble',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path><path d="M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"></path><path d="M8.56 2.75c4.37 6 6 9.42 8 17.72"></path></svg>'
    ],
    'instagram' => [
        'url' => 'https://instagram.com/',
        'label' => 'Instagram',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>'
    ],
    'youtube' => [
        'url' => 'https://youtube.com/',
        'label' => 'YouTube',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>'
    ],
    'facebook' => [
        'url' => 'https://facebook.com/',
        'label' => 'Facebook',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>'
    ],
    'email' => [
        'url' => 'mailto:',
        'label' => 'Email',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>'
    ],
    'codepen' => [
        'url' => 'https://codepen.io/',
        'label' => 'CodePen',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"></polygon><line x1="12" y1="22" x2="12" y2="15.5"></line><polyline points="22 8.5 12 15.5 2 8.5"></polyline><polyline points="2 15.5 12 8.5 22 15.5"></polyline><line x1="12" y1="2" x2="12" y2="8.5"></line></svg>'
    ],
];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
  <ul class="social-icons__list" role="list">
    @foreach($platforms as $platform)
      @if(is_array($platform))
        @php
          // Custom platform with URL and icon
          $url = $platform['url'] ?? '#';
          $label = $platform['label'] ?? 'Social Link';
          $icon = $platform['icon'] ?? '';
        @endphp
      @else
        @php
          // Predefined platform
          $data = $platformData[strtolower($platform)] ?? null;
          if (!$data) continue;
          $url = $data['url'];
          $label = $data['label'];
          $icon = $data['icon'];
        @endphp
      @endif

      <li class="social-icons__item">
        <a
          href="{{ $url }}"
          class="social-icons__link"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="{{ $label }}"
        >
          <span class="social-icons__icon" aria-hidden="true">
            {!! $icon !!}
          </span>
          @if($variant === 'labeled')
            <span class="social-icons__label">{{ $label }}</span>
          @endif
        </a>
      </li>
    @endforeach
  </ul>
</div>
