# Theme Distribution Guide

## Plugin Dependencies: NONE! ✅

This theme has **ZERO runtime dependencies** on plugins. It works completely standalone with WordPress core.

## Understanding Translation Tools vs Dependencies

### 🛠️ Translation TOOLS (Optional - Only for Creating Translations)
- **Loco Translate** (WordPress plugin)
- **Poedit** (Desktop application)
- **WP-CLI** (Command-line tool)

These are like Microsoft Word for creating documents. You use them once to create translation files, then you don't need them anymore.

### ⚙️ Translation FILES (Included with Theme)
- **`.po` files** (human-readable translations)
- **`.mo` files** (compiled translations for WordPress)
- **`.pot` file** (template for creating new translations)

These files work natively with WordPress core - no plugins required!

---

## Distribution Options

### Option 1: Pre-Translated Theme (Recommended for End Users)

**Include complete translation files in the theme package:**

```
📦 alpacodestudio-theme.zip
├── languages/
│   ├── sage.pot          ← Template for additional languages
│   ├── sage-it_IT.po     ← Italian (human-readable)
│   ├── sage-it_IT.mo     ← Italian (compiled)
│   ├── sage-en_US.po     ← English (human-readable)
│   ├── sage-en_US.mo     ← English (compiled)
│   ├── sage-es_ES.po     ← Spanish (human-readable)
│   ├── sage-es_ES.mo     ← Spanish (compiled)
│   └── README.md         ← How to add more languages
├── ... rest of theme files
```

**Workflow:**
1. Before distribution: Create all translation files using Loco Translate or Poedit
2. Test all languages work correctly
3. Package theme with `/languages/` folder included
4. Distribute

**User Experience:**
- ✅ Works immediately out of the box
- ✅ Language selector shows all 3 languages
- ✅ No configuration needed
- ✅ Professional, polished experience

**Best For:**
- Commercial themes
- Marketplaces (ThemeForest, etc.)
- Client projects
- General public distribution

---

### Option 2: Translation-Ready Theme (For Developers)

**Include only the `.pot` template:**

```
📦 alpacodestudio-theme.zip
├── languages/
│   ├── sage.pot                ← Translation template
│   ├── README.md               ← Setup instructions
│   └── TRANSLATION_GUIDE.md    ← Complete guide
├── ... rest of theme files
```

**User Experience:**
- Users create their own translations
- Requires some technical knowledge
- More flexible for custom needs

**Best For:**
- Developer-focused distribution
- GitHub releases
- Open-source projects
- Themes meant for customization

---

## How to Prepare for Distribution

### Step 1: Create Translation Files (One Time)

**Using Loco Translate (Easiest):**
```
1. Install Loco Translate plugin
2. Go to: Loco Translate → Themes → Alpacode Studio Theme
3. For each language (it_IT, en_US, es_ES):
   - Click "New language"
   - Select locale
   - Translate all strings
   - Click "Save"
4. Files are auto-generated in /languages/
5. Uninstall Loco Translate (optional - not needed anymore!)
```

**Using Poedit (Desktop):**
```
1. Open Poedit
2. File → New from POT/PO file → Select languages/sage.pot
3. Choose target language (Italian, English, Spanish)
4. Translate all strings
5. Save as languages/sage-it_IT.po (Poedit auto-creates .mo)
6. Repeat for each language
```

### Step 2: Verify Translation Files

```bash
# Check all files exist
ls -la languages/

# Expected output:
# sage.pot      ← Template
# sage-it_IT.po ← Italian source
# sage-it_IT.mo ← Italian compiled
# sage-en_US.po ← English source
# sage-en_US.mo ← English compiled
# sage-es_ES.po ← Spanish source
# sage-es_ES.mo ← Spanish compiled
```

### Step 3: Test Translations

1. Set WordPress to Italian: **Settings → General → Site Language → Italiano**
2. Check all text appears in Italian
3. Repeat for English and Spanish
4. Test the language selector in header
5. Verify cookie persistence (language saves after reload)

### Step 4: Package Theme

**Include these files:**
```
alpacodestudio-theme/
├── app/
├── config/
│   └── i18n.php              ← Language configuration
├── languages/
│   ├── sage.pot              ← Always include
│   ├── sage-it_IT.po         ← Include if Option 1
│   ├── sage-it_IT.mo         ← Include if Option 1
│   ├── sage-en_US.po         ← Include if Option 1
│   ├── sage-en_US.mo         ← Include if Option 1
│   ├── sage-es_ES.po         ← Include if Option 1
│   ├── sage-es_ES.mo         ← Include if Option 1
│   ├── README.md             ← Always include
│   └── TRANSLATION_GUIDE.md  ← Always include
├── resources/
├── docs/
│   └── LANGUAGE_SELECTOR.md  ← Document the feature
├── README.md                  ← Mention i18n support
└── ... rest of theme
```

**Exclude from package:**
```
.git/
.github/
node_modules/
vendor/ (if using Composer)
.env
*.log
```

### Step 5: Update Documentation

**In your theme's README.md, add:**
```markdown
## Features

- 🌍 **Multi-Language Support** - Built-in language selector
- Supports Italian (default), English, and Spanish
- Easy to add more languages
- No plugin dependencies!

## Translation

This theme is fully translation-ready and includes:
- Italian (it_IT) - Default
- English (en_US)
- Spanish (es_ES)

To add more languages, see `/languages/TRANSLATION_GUIDE.md`
```

---

## WordPress.org Theme Repository (If Applicable)

If submitting to WordPress.org, they have specific requirements:

### Required:
- ✅ `.pot` file must be included in `/languages/`
- ✅ Text domain must match theme slug
- ✅ All strings must use proper i18n functions
- ✅ No plugin dependencies

### Optional:
- Pre-translated `.po` and `.mo` files
- Translation guidelines

### Theme Check:
```bash
# They'll verify:
- Text domain is 'sage'
- All strings are translatable
- No hardcoded text
- Proper use of __(), _e(), _n(), etc.
```

---

## For Commercial Marketplaces (ThemeForest, etc.)

### What Buyers Expect:
- ✅ Complete translations in major languages
- ✅ Working language selector
- ✅ Professional documentation
- ✅ Easy to add more languages

### Documentation to Include:
1. **Quick Start Guide** - How to use language selector
2. **Translation Guide** - How to add new languages
3. **Demo Content** - In all supported languages (if applicable)
4. **Screenshots** - Showing language selector in action

---

## Version Control (.gitignore)

**Recommended .gitignore for theme development:**
```gitignore
# WordPress
wp-config.php
wp-content/uploads/
*.log

# Dependencies
/node_modules/
/vendor/

# Build files (include in distribution, exclude from repo)
/public/build/

# Translation compiled files (CHOOSE ONE):

# Option A: Track .mo files (easier for collaborators)
# (no exclusion needed)

# Option B: Don't track .mo files (regenerate on build)
*.mo

# Environment
.env
.env.*
```

**Recommendation:** Include `.mo` files in version control so they're ready for distribution.

---

## Automatic Translation File Generation (Advanced)

If you want to automate `.pot` file generation during your build process:

**Using Composer (if available):**
```json
{
  "scripts": {
    "translate:pot": "wp i18n make-pot . languages/sage.pot --domain=sage"
  }
}
```

**Using npm:**
```json
{
  "scripts": {
    "translate:pot": "wp i18n make-pot . languages/sage.pot --domain=sage",
    "translate:mo": "wp i18n make-mo languages/"
  }
}
```

**Then in your build process:**
```bash
npm run translate:pot   # Generate .pot from source code
npm run translate:mo    # Compile .po to .mo files
```

---

## FAQ for Users

### "Do I need to install any plugins?"
**No!** The theme works completely standalone. Loco Translate is only a tool to CREATE translations if you want to add more languages.

### "Can I add more languages after installing?"
**Yes!** Users can install Loco Translate themselves and add any language. Your theme is fully translation-ready.

### "What if I want to modify the translations?"
Edit the `.po` files in `/languages/` using Poedit or Loco Translate, then recompile to `.mo`.

### "Will the language selector work without plugins?"
**Yes!** It uses pure WordPress core functions and Alpine.js (already in your theme).

---

## Summary

### ✅ What's Included (No Plugins Needed):
- Language selector component
- AJAX language switching
- Cookie-based preferences
- WordPress core i18n integration
- Italian, English, Spanish support

### 🛠️ What's Optional (Tools Only):
- Loco Translate - for creating translations
- Poedit - for creating translations
- WP-CLI - for automation

### 📦 Distribution Checklist:
- [ ] Create all translation files (`.po` and `.mo`)
- [ ] Include `.pot` template
- [ ] Test all languages
- [ ] Document the feature
- [ ] Package theme
- [ ] Verify no plugin dependencies in runtime code
- [ ] Update README with translation info

---

**Bottom Line:** Your theme is 100% independent. Loco Translate is just a convenient TOOL (like Photoshop for images), not a DEPENDENCY (like jQuery would be). Users can install the theme and immediately switch between Italian, English, and Spanish with zero plugins!

🎉 **Professional. Independent. Production-Ready.**
