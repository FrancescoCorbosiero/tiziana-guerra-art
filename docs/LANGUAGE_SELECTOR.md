# Language Selector Documentation

## Overview

The Alpacode Studio Theme now includes a powerful, fully-integrated **Language Selector** component that allows users to seamlessly switch between different languages on your multilingual website.

## Features

- 🎨 **Seamlessly Integrated Design** - Matches the theme's modern design system perfectly
- 🌍 **Multi-Language Support** - Supports unlimited languages with easy configuration
- 📱 **Fully Responsive** - Works beautifully on desktop and mobile devices
- ♿ **Accessible** - ARIA labels, keyboard navigation, and screen reader support
- ⚡ **AJAX-Powered** - Instant language switching without page reload preparation
- 🎭 **Dark Mode Compatible** - Adapts to light and dark themes automatically
- 🔄 **RTL Support** - Built-in support for right-to-left languages

## How It Works

The language selector integrates with WordPress's native internationalization system and the theme's custom `I18nService`:

1. **Configuration** - Languages are defined in `/config/i18n.php`
2. **Component** - Visual selector in `/resources/views/components/language-selector.blade.php`
3. **AJAX Handler** - Language switching logic in `/app/setup.php`
4. **Service Layer** - `I18nService` manages locale detection and switching
5. **Cookie Persistence** - User's language preference is saved for 1 year

## Adding New Languages

### Step 1: Update i18n Configuration

Edit `/config/i18n.php` and add your language to the `available_locales` array:

```php
'available_locales' => [
    'en_US' => 'English (US)',
    'it_IT' => 'Italiano',
    'es_ES' => 'Español',        // ← New language
    'fr_FR' => 'Français',       // ← New language
    'de_DE' => 'Deutsch',        // ← New language
],
```

### Step 2: Add Language Translations

Create translation files in `/languages/`:

```
/languages/
  ├── en_US.po
  ├── en_US.mo
  ├── it_IT.po
  ├── it_IT.mo
  ├── es_ES.po   ← New
  ├── es_ES.mo   ← New
  └── ...
```

You can create these using tools like:
- [Poedit](https://poedit.net/) (GUI application)
- [Loco Translate](https://wordpress.org/plugins/loco-translate/) (WordPress plugin)
- [WPML](https://wpml.org/) (Premium plugin)

### Step 3: Configure Flag Emojis (Optional)

To customize the flag shown for a language, edit the `$localeInfo` array in `/resources/views/components/language-selector.blade.php`:

```php
$localeInfo = [
    'en_US' => ['flag' => '🇺🇸', 'short' => 'EN'],
    'it_IT' => ['flag' => '🇮🇹', 'short' => 'IT'],
    'es_ES' => ['flag' => '🇪🇸', 'short' => 'ES'],  // ← New
    'fr_FR' => ['flag' => '🇫🇷', 'short' => 'FR'],  // ← New
    'de_DE' => ['flag' => '🇩🇪', 'short' => 'DE'],  // ← New
];
```

### Step 4: WordPress Language Packs

Install WordPress language packs for complete admin translation:

1. Go to **Settings → General** in WordPress admin
2. Select your **Site Language**
3. WordPress will automatically download the language pack

## Supported Languages

The component includes pre-configured support for:

| Language | Code | Flag |
|----------|------|------|
| English (US) | `en_US` | 🇺🇸 |
| Italian | `it_IT` | 🇮🇹 |
| Spanish | `es_ES` | 🇪🇸 |
| French | `fr_FR` | 🇫🇷 |
| German | `de_DE` | 🇩🇪 |
| Portuguese (Brazil) | `pt_BR` | 🇧🇷 |
| Japanese | `ja_JP` | 🇯🇵 |
| Chinese (Simplified) | `zh_CN` | 🇨🇳 |
| Arabic | `ar` | 🇸🇦 |
| Hebrew | `he_IL` | 🇮🇱 |
| Persian | `fa_IR` | 🇮🇷 |
| Urdu | `ur` | 🇵🇰 |

**Note:** Only languages added to `available_locales` in `/config/i18n.php` will appear in the selector.

## RTL (Right-to-Left) Languages

The theme automatically detects and applies RTL layout for the following languages:

- Arabic (`ar`)
- Hebrew (`he_IL`)
- Persian/Farsi (`fa_IR`)
- Urdu (`ur`)

To add more RTL languages, edit `/config/i18n.php`:

```php
'rtl_locales' => [
    'ar',
    'he_IL',
    'fa_IR',
    'ur',
    'ku',    // ← Kurdish (example)
],
```

## Component Locations

The language selector appears in two locations:

### Desktop Header
Located in the header actions bar, between the search button and theme toggle.

**File:** `/resources/views/sections/header.blade.php` (line 66)

```blade
{{-- Language Selector --}}
@include('components.language-selector')
```

### Mobile Menu
Located in the mobile menu footer for easy access on mobile devices.

**File:** `/resources/views/sections/header.blade.php` (line 157-159)

```blade
<div class="mobile-menu__language">
  @include('components.language-selector')
</div>
```

## Customization

### Styling

The language selector uses the theme's design tokens. To customize:

**File:** `/resources/css/components/_language-selector.css`

```css
.language-selector__dropdown {
  /* Customize dropdown background */
  background: var(--color-surface-raised);

  /* Customize border */
  border: 1px solid color-mix(in oklch, var(--color-text-primary), transparent 90%);

  /* Customize shadow */
  box-shadow: var(--shadow-xl);
}
```

### Removing from Header

To remove from desktop header, comment out or delete this line in `/resources/views/sections/header.blade.php`:

```blade
{{-- @include('components.language-selector') --}}
```

### Removing from Mobile Menu

To remove from mobile menu, comment out or delete this section:

```blade
{{--
<div class="mobile-menu__language">
  @include('components.language-selector')
</div>
--}}
```

## Browser Language Detection

The theme can automatically detect the user's browser language on first visit:

**File:** `/config/i18n.php`

```php
'auto_detect' => true,  // Set to false to disable
```

When enabled, the theme will:
1. Check for a saved cookie preference
2. If none, parse the `Accept-Language` header
3. Match against available locales
4. Fallback to `default_locale` if no match

## Translation Functions

Use these functions in your templates:

### Basic Translation
```php
{{ __('Hello World', 'sage') }}
```

### Translation with Variables
```php
<?php
$i18n = app(\App\Services\I18nService::class);
echo $i18n->translate('Welcome :name', ['name' => 'John']);
?>
```

### Pluralization
```php
{{ _n('1 item', '%d items', $count, 'sage') }}
```

### Get Current Locale
```php
<?php
$i18n = app(\App\Services\I18nService::class);
$locale = $i18n->getLocale(); // Returns 'en_US', 'it_IT', etc.
?>
```

## Integration with Plugins

The language selector works alongside popular translation plugins:

### Polylang
1. Install and activate Polylang
2. Configure languages in **Languages** admin menu
3. Theme's `I18nService` will work with Polylang's locale switching

### WPML
1. Install and activate WPML
2. Configure languages in **WPML** menu
3. The language selector complements WPML's language switcher

### TranslatePress
1. Install and activate TranslatePress
2. Configure in **Settings → TranslatePress**
3. Works seamlessly with the theme's selector

## API Reference

### I18nService Methods

```php
use App\Services\I18nService;

$i18n = app(I18nService::class);

// Get current locale
$locale = $i18n->getLocale();

// Get available locales
$locales = $i18n->getAvailableLocales();
// Returns: ['en_US' => 'English (US)', 'it_IT' => 'Italiano']

// Translate with replacements
$translated = $i18n->translate('Hello :name', ['name' => 'World']);

// Check if RTL
$isRtl = $i18n->isRtl();

// Set locale (saves cookie)
$i18n->setLocale('it_IT');

// Detect browser locale
$detected = $i18n->detectBrowserLocale();
```

## Troubleshooting

### Language selector not appearing
1. Clear cache: `npm run build`
2. Check if CSS is imported in `/resources/css/app.css`
3. Verify component file exists at `/resources/views/components/language-selector.blade.php`

### AJAX not working
1. Check browser console for JavaScript errors
2. Verify nonce is being generated correctly
3. Ensure AJAX handlers are registered in `/app/setup.php`

### Translations not loading
1. Verify `.mo` files exist in `/languages/` directory
2. Check text domain is `'sage'` in all translation functions
3. Ensure locale code matches WordPress standards (e.g., `it_IT` not `it`)

### Cookie not persisting
1. Check browser allows cookies
2. Verify cookie path is set to `/` in `I18nService::setLocale()`
3. Clear browser cookies and try again

## Performance Considerations

- **Cookie-based**: Language preference is stored in a cookie (1-year expiration)
- **No Database**: No database queries for language switching
- **Lightweight**: Minimal JavaScript (uses Alpine.js already loaded)
- **CSS Optimized**: Uses native CSS custom properties and modern features

## Security

- ✅ **Nonce verification** on all AJAX requests
- ✅ **Input sanitization** with `sanitize_text_field()`
- ✅ **Whitelist validation** against available locales
- ✅ **Secure cookies** with proper path and expiration

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Opera 76+
- Mobile browsers (iOS Safari 14+, Chrome Android 90+)

**Note:** Older browsers may not support all CSS features (oklch colors, clamp, etc.) but will receive graceful fallbacks.

## Credits

- **Design**: Alpacode Studio design system
- **Icons**: Custom SVG icons
- **Flags**: Unicode emoji flags
- **Framework**: WordPress + Sage 10 + Alpine.js

## Need Help?

For support or questions:
- Check the [theme documentation](/docs/)
- Visit [Alpacode Studio](https://alpacode.studio)
- Submit an issue on GitHub

---

**Version:** 1.0.0
**Last Updated:** {{ date('Y-m-d') }}
**License:** MIT
