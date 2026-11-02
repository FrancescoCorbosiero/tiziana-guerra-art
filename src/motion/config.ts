/* ============================================================
   tizianaguerra.art — the site's half of the core.
   From alpacode-motion src/engine/config.ts (7b1a203); core/ and
   effects/ are copied from there, this file and registry.ts are the
   site's. A site's classes live here, never in an effect (D5).
   ============================================================ */

export const config = {
  /** The theme has its own header and sticky bar (SiteHeader.astro):
   *  core-header stays off, nothing carries data-header. */
  header: "[data-header]",
  navOpen: "",
  /** The Popover overlays (menu, search, zoom) get aria-modal while
   *  open (scripts/overlays.ts): Lenis stands down over them. */
  scrollPanes: "[aria-modal='true']",
  /** What the CSS intro moves on first paint (global.css): the titles
   *  split in words, the blocks that fade in, the hero's works. */
  intro: ".intro-words, .reveal, .intro-clip",
  /** The site's own classes for a hook. */
  selectors: {
    // the artworks of every grid (Pitture, Galleria, related works)
    "[data-reveal]": [".masonry__item", ".cs-voce"],
  } as Record<string, string[]>,
};
