# i18n Quick Reference Card

**Print this or keep it open while developing!**

---

## 🎯 Golden Rules

| Rule | Code |
|------|------|
| **Text Domain** | Always `'sage'` |
| **User Text** | Always translated |
| **Variables** | Use `sprintf()` |
| **Text + HTML** | Use `{!! sprintf() !!}` |

---

## 🔧 Translation Functions Cheat Sheet

### Basic Translation
```php
// Return translated string
$text = __('Hello', 'sage');

// Echo translated string
_e('Hello', 'sage');

// In Blade
{{ __('Hello', 'sage') }}
```

### With Variables
```php
// One variable
sprintf(__('Hello %s', 'sage'), $name)

// Multiple variables
sprintf(__('Hello %s, you have %d messages', 'sage'), $name, $count)

// Named placeholders (recommended)
sprintf(__('Hello %(name)s, you have %(count)d messages', 'sage'), $name, $count)
```

### Pluralization
```php
// Singular/plural
sprintf(_n('%d item', '%d items', $count, 'sage'), $count)

// Example: "1 item" or "5 items"
```

### With Context
```php
// When word has multiple meanings
_x('Post', 'noun - blog post', 'sage')      // "Post" as a noun
_x('Post', 'verb - submit', 'sage')         // "Post" as a verb
```

### Escaped Translations
```php
// For output (escapes HTML)
esc_html__('Text', 'sage')

// For attributes
esc_attr__('Text', 'sage')

// For JavaScript
esc_js__('Text', 'sage')
```

---

## 📝 Common Patterns

### Button Text
```blade
<button>{{ __('Submit', 'sage') }}</button>
<button>{{ __('Read more', 'sage') }}</button>
<button>{{ __('Close', 'sage') }}</button>
```

### ARIA Labels
```blade
<button aria-label="{{ __('Open menu', 'sage') }}">
<nav aria-label="{{ __('Primary navigation', 'sage') }}">
<input placeholder="{{ __('Search...', 'sage') }}">
```

### Messages
```php
// Success
__('Changes saved successfully', 'sage')

// Error
__('An error occurred. Please try again.', 'sage')

// Info
__('Loading...', 'sage')
```

### Navigation
```blade
{{ __('Home', 'sage') }}
{{ __('About', 'sage') }}
{{ __('Contact', 'sage') }}
{{ __('Previous', 'sage') }}
{{ __('Next', 'sage') }}
```

### Forms
```blade
<label>{{ __('Email address', 'sage') }}</label>
<label>{{ __('Password', 'sage') }}</label>
<button type="submit">{{ __('Submit', 'sage') }}</button>
```

### Dates & Times
```php
// With date
sprintf(__('Published on %s', 'sage'), $date)

// With author
sprintf(__('By %s', 'sage'), $author)

// With both
sprintf(__('Posted by %1$s on %2$s', 'sage'), $author, $date)
```

---

## ❌ Common Mistakes

### ❌ WRONG
```php
// Missing text domain
__('Text')

// Wrong text domain
__('Text', 'wordpress')

// Concatenation
__('Hello', 'sage') . ' ' . $name

// Variable inside string
__("Hello $name", 'sage')

// Dynamic text domain
$domain = 'sage';
__('Text', $domain)

// No translation
<button>Click me</button>
```

### ✅ CORRECT
```php
// Always specify 'sage'
__('Text', 'sage')

// Use sprintf for variables
sprintf(__('Hello %s', 'sage'), $name)

// Text domain must be literal
__('Text', 'sage')

// Translate all user-facing text
<button>{{ __('Click me', 'sage') }}</button>
```

---

## 🌍 RTL Support

### CSS (Use Logical Properties)
```css
/* ❌ WRONG */
margin-left: 1rem;
text-align: left;
float: left;

/* ✅ CORRECT */
margin-inline-start: 1rem;
text-align: start;
float: inline-start;
```

---

## 📋 Component Checklist

When creating a component:

```
□ All button text translated
□ All ARIA labels translated
□ All placeholder text translated
□ All error messages translated
□ All success messages translated
□ All tooltips translated
□ Text domain is 'sage'
□ No hardcoded strings
□ Variables use sprintf()
□ HTML uses {!! sprintf() !!}
□ Works in RTL (test with 'ar')
```

---

## 🚀 Current Setup

**Default Language:** Italian (it_IT)
**Available Languages:** Italian, English (US), Spanish
**Text Domain:** `sage`
**Service:** `App\Services\I18nService`

### Get I18nService
```php
$i18n = app(\App\Services\I18nService::class);

// Available methods:
$i18n->getLocale()              // 'it_IT'
$i18n->getAvailableLocales()    // ['it_IT' => 'Italiano', ...]
$i18n->setLocale('en_US')       // Switch language
$i18n->translate($key, $vars)   // Translate with variables
$i18n->isRtl()                  // false/true
```

---

## 🔍 Test Your Component

```php
// In browser console
document.cookie = "locale=it_IT; path=/";  // Italian
document.cookie = "locale=en_US; path=/";  // English
document.cookie = "locale=es_ES; path=/";  // Spanish
document.cookie = "locale=ar; path=/";     // Arabic (RTL)
location.reload();
```

---

## 📚 Full Documentation

- **Complete Guide:** `/docs/I18N_DEVELOPMENT_RULES.md`
- **Language Selector:** `/docs/LANGUAGE_SELECTOR.md`
- **Translation Guide:** `/languages/TRANSLATION_GUIDE.md`
- **Distribution:** `/DISTRIBUTION.md`

---

## 💡 Remember

> Every user-facing string MUST be translatable.
> Text domain is ALWAYS `'sage'`.
> Variables use `sprintf()`, never concatenation.
> Test in all three languages before committing.

---

**Keep this handy!** Print it, bookmark it, tattoo it. 😉
