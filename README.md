# alpacode.studio - Sage theme
## ✅ ARCHITECTURE - SOLID FOUNDATION

Sage 10 + CSS4 (Sage default: TailwindCSS) + Alpine.js - Modern stack properly configured

Self-contained blocks philosophy - Template-based approach established

Service layer architecture - ThemeServiceProvider, SeoService, PerformanceService (BlitzThemeService)

Vite build system - HMR, code splitting, optimization configured

FSE available (with smooth Gutenberg integration)

## ✅ CORE SYSTEMS - OPERATIONAL
Backend (PHP/Laravel):
)

- View composers for data binding
- Theme customizer integration
- Security hardening & accessibility features
- Helper functions ecosystem

Frontend (JS/CSS):

- Dark/light/auto theme toggle with persistence
- Navigation enhancement with Speculation Rules API
- View Transitions API for SPA-like navigation
- Service Worker for offline support
- Web Vitals monitoring
- Accessibility features (focus management, ARIA, keyboard nav)
- CSS layer architecture with token system

Internationalization (i18n):

- Multi-language support (Italian default, English, Spanish)
- Language selector component in header
- AJAX-powered language switching with cookie persistence
- Browser language auto-detection
- RTL language support (Arabic, Hebrew, Persian, Urdu)
- I18nService for centralized translation management
- **ZERO plugin dependencies** - uses WordPress core i18n only
- Translation-ready with .pot template included
- See `/docs/I18N_DEVELOPMENT_RULES.md` for development guidelines

## ✅ COMPLETED SECTIONS
Located in resources/views/sections/:

- Header - Responsive navigation
- Hero - Landing section
- Features - Grid/alternating layouts
- About (mission, timeline) - Interactive components
- Services - Service showcase
- Testimonials - Slider implementation
- FAQ - Accordion interface
- Contact - Form with validation
- Footer - Multi-column layout
- CTA - Call-to-action blocks
- Stats - Animated counters
- Pricing - Pricing tables
- Team - Team member cards
- Blog - Blog listing
- Process - Step-by-step visualization

## ✅ REUSABLE COMPONENTS

- Action Board (floating buttons)
- Contact button / Social buttons
- Modal, Toast, Alert, Dropdown, Popover
- Comments system (threaded, reactions)
- Search form
- Enhanced content pages with TOC