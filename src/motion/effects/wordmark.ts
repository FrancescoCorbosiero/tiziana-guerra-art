/* ============================================================
   wordmark — the footer's wordmark: the letters rise out of their
   masks as it comes into view.
   Markup: data-wordmark on the wordmark, its letters already set one
   per [data-wordmark-char] inside a mask (SiteFooter.astro: Syne has
   no kerning pairs in the name, so splitting costs nothing).
   Below the fold only, once.
   Sources: A src/lib/motion.ts:1005 (the variant `rise`, kept here);
   C src/scripts/motion.ts:1161 (`bounce`). No mascot.
   ============================================================ */
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { inFirstView } from "../core/guards";
import type { Kit } from "../core/kit";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-wordmark]";

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const DURATION = 1.2; // s (A)
const STAGGER = 0.045; // s between letters (A)

export function init(kit: Kit): void {
  kit.query(hook).forEach((el) => {
    if (inFirstView(el)) return;
    gsap.from(el.querySelectorAll("[data-wordmark-char]"), {
      yPercent: 110,
      duration: DURATION,
      ease: "power4.out",
      stagger: STAGGER,
      scrollTrigger: { trigger: el, start: "top 98%", once: true },
    });
  });
}
