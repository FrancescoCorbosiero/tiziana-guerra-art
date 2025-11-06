# Translation Files

## Important: No Plugin Dependencies!

**Loco Translate is NOT required for the theme to work.** It's only a TOOL for creating translation files (like Photoshop for images). Once you create the `.po` and `.mo` files, the theme works completely standalone with WordPress core.

## Already Translated?

If you received this theme with pre-created translation files, you're all set! Just:
1. Go to **Settings → General** in WordPress
2. Select your **Site Language**
3. Or use the language selector in the header

## Creating New Translations

If you want to add more languages or modify existing translations, you have two main options:

### Option 1: Loco Translate Plugin (Recommended - Easiest)

1. Install the free [Loco Translate](https://wordpress.org/plugins/loco-translate/) plugin
2. Go to **Loco Translate → Themes** in WordPress admin
3. Select "Alpacode Studio Theme"
4. Click "New language"
5. Select "Italian (Italy) - it_IT"
6. Click "Start translating"
7. Translate all strings in the web interface
8. Click "Save" - it will generate .po and .mo files automatically

### Option 2: Poedit Desktop App

1. Download [Poedit](https://poedit.net/) (free for basic use)
2. Open Poedit
3. Click "Create new translation"
4. Select this theme directory
5. Choose Italian (it_IT) as target language
6. Poedit will scan for translatable strings
7. Translate each string
8. Save - it will create it_IT.po and it_IT.mo files

## Translation Strings Found

The theme contains approximately 50+ translatable strings including:
- Navigation labels
- Button text
- Error messages
- Form labels
- Comment section text
- Language selector text
- And more...

## Files Structure

After translation, you should have:
```
languages/
  ├── sage-it_IT.po   (human-readable translations)
  ├── sage-it_IT.mo   (compiled machine-readable)
  ├── sage-en_US.po
  ├── sage-en_US.mo
  ├── sage-es_ES.po
  └── sage-es_ES.mo
```

**Note:** WordPress requires the filename format: `{textdomain}-{locale}.po/mo`
Where textdomain is 'sage' (defined in config/i18n.php)
