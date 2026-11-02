/* ============================================================
   hero-away — hero content drifts off and dims as the page scrolls
   away. Markup: data-hero-away[="14"] (yPercent) on the content,
   data-hero-fade (end opacity, default 0.2). Scrubbed over its
   section, from its top at the top of the screen to its foot there.
   Its CSS intro moves the inner words, never the element itself, so
   the two don't fight.
   Sources: C src/scripts/motion.ts:1148; A src/lib/motion.ts:925
   ([data-hero-content]: -14, 0.15).
   ============================================================ */
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import type { Kit } from "../core/kit";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-hero-away]";

export function init(kit: Kit): void {
  kit.query(hook).forEach((el) => {
    const section = el.closest("section") ?? el;
    gsap.to(el, {
      yPercent: Number(el.dataset.heroAway) || 14,
      opacity: Number(el.dataset.heroFade ?? 0.2),
      ease: "none",
      scrollTrigger: { trigger: section, start: "top top", end: "bottom top", scrub: true },
    });
  });
}
