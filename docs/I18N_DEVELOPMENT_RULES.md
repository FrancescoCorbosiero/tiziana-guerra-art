# i18n Development Rules & Guidelines

## Developer Point of View: Building Multilingual Components

When developing components and sections for this theme, you MUST follow these internationalization (i18n) rules to maintain the theme's multilingual capabilities.

---

## 🎯 Core Principles

### 1. **NEVER hardcode user-facing text**
### 2. **ALWAYS use WordPress translation functions**
### 3. **Text domain is ALWAYS 'sage'**
### 4. **Think multilingual from the start, not as an afterthought**

---

## 📋 Required Rules for Component Development

### Rule 1: All User-Facing Text Must Be Translatable

**❌ WRONG:**
```php
<button>Submit</button>
<p>Welcome to our site</p>
<span>Published on <?php echo $date; ?></span>
```

**✅ CORRECT:**
```php
<button>{{ __('Submit', 'sage') }}</button>
<p>{{ __('Welcome to our site', 'sage') }}</p>
<span>{{ sprintf(__('Published on %s', 'sage'), $date) }}</span>
```

### Rule 2: Use Appropriate Translation Functions

| Function | Use Case | Example |
|----------|----------|---------|
| `__()` | Return translated string | `$text = __('Hello', 'sage')` |
| `_e()` | Echo translated string | `_e('Hello', 'sage')` |
| `_n()` | Singular/plural | `_n('1 item', '%d items', $count, 'sage')` |
| `_x()` | With context | `_x('Post', 'noun', 'sage')` |
| `esc_html__()` | Escape and translate | `esc_html__('Title', 'sage')` |
| `esc_attr__()` | For attributes | `esc_attr__('Title', 'sage')` |

### Rule 3: In Blade Templates, Use Blade Syntax

**❌ WRONG:**
```php
<?php _e('Text', 'sage'); ?>
<?php echo __('Text', 'sage'); ?>
```

**✅ CORRECT:**
```blade
{{ __('Text', 'sage') }}
{!! __('Text with <strong>HTML</strong>', 'sage') !!}
@php _e('Text', 'sage') @endphp
```

### Rule 4: Variables in Translations

**❌ WRONG:**
```php
{{ __("Hello $name", 'sage') }}  // Variables inside string won't translate
{{ __('Hello') . ' ' . $name }}  // Concatenation breaks context
```

**✅ CORRECT:**
```php
{{ sprintf(__('Hello %s', 'sage'), $name) }}
{{ printf(__('Hello %s', 'sage'), $name) }}
```

### Rule 5: Provide Context for Ambiguous Words

**❌ WRONG:**
```php
{{ __('Post', 'sage') }}  // Post the verb? Post the noun? Blog post?
```

**✅ CORRECT:**
```php
{{ _x('Post', 'noun - blog post', 'sage') }}
{{ _x('Post', 'verb - submit', 'sage') }}
```

### Rule 6: Pluralization

**❌ WRONG:**
```php
{{ $count }} {{ __('items', 'sage') }}  // Always says "items" even for 1
{{ $count == 1 ? __('item', 'sage') : __('items', 'sage') }}  // Doesn't work for all languages
```

**✅ CORRECT:**
```php
{{ sprintf(_n('%d item', '%d items', $count, 'sage'), $count) }}
```

### Rule 7: HTML in Translations

**When HTML is needed in translation:**

**❌ WRONG:**
```php
{{ __('Click') }} <a href="#">{{ __('here') }}</a>  // Breaks sentence structure
```

**✅ CORRECT:**
```php
{!! sprintf(__('Click <a href="%s">here</a>', 'sage'), $url) !!}
```

### Rule 8: Attribute Values

**❌ WRONG:**
```php
<button aria-label="Close">X</button>
<input placeholder="Search...">
```

**✅ CORRECT:**
```php
<button aria-label="{{ __('Close', 'sage') }}">X</button>
<input placeholder="{{ __('Search...', 'sage') }}">
```

### Rule 9: JavaScript Strings

**For strings used in JavaScript:**

**Option A: Inline in Blade:**
```blade
<script>
const message = "{{ __('Are you sure?', 'sage') }}";
</script>
```

**Option B: wp_localize_script:**
```php
// In setup.php or service
wp_localize_script('app', 'themeStrings', [
    'confirm' => __('Are you sure?', 'sage'),
    'success' => __('Success!', 'sage'),
]);

// In JavaScript
alert(themeStrings.confirm);
```

### Rule 10: Comments and Documentation

**Code comments should NOT be translated:**
```php
// This is a comment - keep in English for developers
{{ __('This is user text', 'sage') }}  // This text WILL be translated
```

---

## 🏗️ Current Theme Architecture

### Translation System Overview

```
┌─────────────────────────────────────────────┐
│  User Visits Site                           │
└─────────────────┬───────────────────────────┘
                  ↓
┌─────────────────────────────────────────────┐
│  I18nService::getLocale()                   │
│  - Checks cookie preference                 │
│  - Falls back to WordPress setting          │
│  - Falls back to browser language           │
│  - Falls back to default (it_IT)            │
└─────────────────┬───────────────────────────┘
                  ↓
┌─────────────────────────────────────────────┐
│  WordPress loads sage-{locale}.mo           │
│  - Example: sage-it_IT.mo                   │
└─────────────────┬───────────────────────────┘
                  ↓
┌─────────────────────────────────────────────┐
│  All __() functions use loaded locale       │
│  - Components render in correct language    │
│  - No plugin dependencies                   │
└─────────────────────────────────────────────┘
```

### Current Setup

**Configuration:** `/config/i18n.php`
```php
'default_locale' => 'it_IT',        // Italian default
'available_locales' => [
    'it_IT' => 'Italiano',          // Primary
    'en_US' => 'English (US)',      // Secondary
    'es_ES' => 'Español',           // Secondary
],
'fallback_locale' => 'it_IT',
'text_domain' => 'sage',            // Always use this!
```

**Service:** `/app/Services/I18nService.php`
```php
// Available methods:
$i18n->getLocale()              // Get current locale
$i18n->setLocale('it_IT')       // Set locale + cookie
$i18n->getAvailableLocales()    // Get all configured locales
$i18n->translate($key, $vars)   // Translate with variables
$i18n->isRtl()                  // Check if RTL language
$i18n->detectBrowserLocale()    // Auto-detect from browser
```

**Component:** `/resources/views/components/language-selector.blade.php`
- Dropdown in header for language switching
- AJAX-powered, no page reload
- Cookie persistence (1 year)
- Mobile-optimized

**Dependencies:** ZERO
- Uses WordPress core i18n functions only
- No plugins required at runtime
- Loco Translate is optional tool for creating translations

---

## ✅ Component Development Checklist

When creating a new component or section:

```
□ All user-facing text uses translation functions
□ Text domain is 'sage' everywhere
□ Variables use sprintf() or printf()
□ Ambiguous words have context via _x()
□ Plurals use _n()
□ ARIA labels are translated
□ Button text is translated
□ Placeholder text is translated
□ Error messages are translated
□ Success messages are translated
□ No hardcoded strings remain
□ JavaScript strings use wp_localize_script or inline Blade
□ HTML in translations uses sprintf() with {!! !!}
□ Comments remain in English
□ Component works with RTL languages (test with 'ar' locale)
```

---

## 🎨 Real Examples from Theme

### Example 1: Language Selector Component

**File:** `/resources/views/components/language-selector.blade.php`

```blade
{{-- Good: Button label translated --}}
<button
  aria-label="{{ __('Select language', 'sage') }}"
  aria-haspopup="true"
>
  {{-- SVG icon --}}
  <span class="sr-only">
    {{ __('Current language', 'sage') }}: {{ $availableLocales[$currentLocale] }}
  </span>
</button>

{{-- Good: Dropdown title translated --}}
<span class="language-selector__dropdown-title">
  {{ __('Select Language', 'sage') }}
</span>
```

### Example 2: Header Section

**File:** `/resources/views/sections/header.blade.php`

```blade
{{-- Good: Search button label --}}
<button
  aria-label="{{ __('Open search', 'sage') }}"
>
  {{-- Icon --}}
  <span class="sr-only">{{ __('Search', 'sage') }}</span>
</button>

{{-- Good: Skip link for accessibility --}}
<a class="skip-link" href="#main">
  {{ __('Skip to content', 'sage') }}
</a>
```

### Example 3: Setup AJAX Handlers

**File:** `/app/setup.php`

```php
// Good: Error and success messages translated
add_action('wp_ajax_switch_locale', function () {
    if (empty($locale)) {
        wp_send_json_error([
            'message' => __('Invalid locale', 'sage')
        ]);
    }

    wp_send_json_success([
        'message' => __('Language changed successfully', 'sage')
    ]);
});
```

### Example 4: Post Meta

**File:** `/resources/views/partials/entry-meta.blade.php`

```blade
{{-- Good: "By" text translated --}}
<span>{{ __('By', 'sage') }}</span>
<a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}">
  {{ get_the_author() }}
</a>
```

### Example 5: 404 Page

**File:** `/resources/views/404.blade.php`

```blade
{{-- Good: Error message translated --}}
<p>
  {{ __('Sorry, the page you are looking for could not be found.', 'sage') }}
</p>

{{-- Good: Button text translated --}}
<x-button href="{{ home_url('/') }}">
  {{ __('Go Home', 'sage') }}
</x-button>
```

---

## 🚫 Common Mistakes to Avoid

### Mistake 1: Wrong Text Domain
```php
// ❌ WRONG
__('Text', 'wordpress')
__('Text', 'my-theme')
__('Text')  // Missing domain

// ✅ CORRECT
__('Text', 'sage')
```

### Mistake 2: Concatenation
```php
// ❌ WRONG
$message = __('Hello', 'sage') . ' ' . $name . ', ' . __('welcome', 'sage');

// ✅ CORRECT
$message = sprintf(__('Hello %s, welcome!', 'sage'), $name);
```

### Mistake 3: Dynamic Text Domain
```php
// ❌ WRONG
$domain = 'sage';
__('Text', $domain)  // Text domain must be literal string!

// ✅ CORRECT
__('Text', 'sage')
```

### Mistake 4: Translation in Database
```php
// ❌ WRONG
update_option('site_tagline', __('Tagline', 'sage'));  // Translates once, gets stuck

// ✅ CORRECT
$tagline = __('Tagline', 'sage');  // Translate at display time
```

### Mistake 5: HTML Entities
```php
// ❌ WRONG
{{ __('&copy; 2025 Company', 'sage') }}  // &copy; in translation file

// ✅ CORRECT
{!! sprintf(__('&copy; %s Company', 'sage'), date('Y')) !!}
```

---

## 🌍 RTL Language Support

### Components Must Work in RTL

**CSS Variables (already handled):**
```css
[dir="rtl"] .component {
  /* Automatically flips for Arabic, Hebrew, etc. */
}
```

**Test Your Component:**
1. Switch to Arabic (`ar`) in config
2. Verify layout doesn't break
3. Ensure text aligns correctly
4. Check icon positioning

**RTL-Safe CSS:**
```css
/* ❌ WRONG - breaks in RTL */
.element {
  margin-left: 1rem;
  text-align: left;
}

/* ✅ CORRECT - works in RTL */
.element {
  margin-inline-start: 1rem;  /* Logical property */
  text-align: start;          /* Logical value */
}
```

---

## 📊 Translation Coverage

### Current Translatable Strings: ~50+

**Categories:**
- Navigation: ~5 strings
- Buttons/Actions: ~10 strings
- Messages/Errors: ~8 strings
- Forms: ~5 strings
- Comments: ~6 strings
- Post Navigation: ~4 strings
- Language Selector: ~3 strings
- Accessibility: ~5 strings
- Misc: ~10 strings

### Generating POT File

When you add new translatable strings, regenerate the `.pot` template:

```bash
# Using WP-CLI (if available)
wp i18n make-pot . languages/sage.pot --domain=sage

# Or use Loco Translate in WordPress admin
Loco Translate → Themes → Alpacode Studio → Extract template
```

---

## 🔄 Development Workflow

### When Creating a New Component:

```
1. Build component structure
2. Add ALL text with translation functions
3. Use correct function for each use case
4. Test in Italian (default)
5. Regenerate .pot if needed
6. Update translations
7. Test in English and Spanish
8. Test RTL if component has directional elements
9. Verify ARIA labels are translated
10. Commit with proper i18n notation
```

### Code Review Checklist:

```
Component Review:
□ No hardcoded user-facing text?
□ All text uses translation functions?
□ Text domain is 'sage'?
□ Variables properly formatted with sprintf()?
□ Context added for ambiguous terms?
□ ARIA labels translated?
□ Works in RTL?
□ JavaScript strings properly localized?
```

---

## 🛠️ Tools & Resources

### Development Tools:
- **Loco Translate** - WordPress plugin for creating translations
- **Poedit** - Desktop app for editing .po files
- **WP-CLI** - Command-line translation tools
- **Better Font Awesome** - Icon library (already in theme)

### Documentation:
- `/docs/LANGUAGE_SELECTOR.md` - Language selector feature docs
- `/languages/TRANSLATION_GUIDE.md` - Complete translation guide
- `/DISTRIBUTION.md` - Distribution and dependency info
- [WordPress i18n Handbook](https://developer.wordpress.org/apis/handbook/internationalization/)

### Testing:
```php
// Quick locale test in browser console
document.cookie = "locale=it_IT; path=/";
document.cookie = "locale=en_US; path=/";
document.cookie = "locale=es_ES; path=/";
location.reload();
```

---

## 📝 Commit Message Convention

When adding i18n to components:

```
feat: Add hero component with i18n support

- All user-facing text uses translation functions
- ARIA labels translated for accessibility
- RTL support included
- Spanish, Italian, English translations ready
- No hardcoded strings remain
```

---

## 🎯 Summary: The Golden Rules

1. **Text Domain = `'sage'`** (always, everywhere)
2. **User Text = Translated** (no exceptions)
3. **Variables = sprintf()** (never concatenate)
4. **Context = _x()** (when word is ambiguous)
5. **Plurals = _n()** (language-aware)
6. **ARIA = Translated** (for accessibility)
7. **JS Strings = Localized** (via wp_localize_script)
8. **RTL = Supported** (use logical properties)
9. **HTML = sprintf()** (for complex markup)
10. **Comments = English** (for developers)

---

## ✨ Result: Professional Multilingual Theme

Following these rules ensures:
- ✅ Theme works in Italian, English, Spanish out of the box
- ✅ Easy to add more languages
- ✅ Professional user experience
- ✅ Accessibility compliant
- ✅ RTL language support
- ✅ Zero plugin dependencies
- ✅ WordPress.org compatible
- ✅ Marketplace ready
- ✅ Client-ready
- ✅ Future-proof

---

**Remember:** i18n is not an afterthought. It's a core architectural decision. Every component, every section, every user-facing string must be translatable from day one.

**Your theme is multilingual by design, not by accident.** 🌍
