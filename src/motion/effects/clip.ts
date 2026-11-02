/* ============================================================
   clip — a photo opens from a clip, its image settling from a slight
   zoom. Markup: data-clip on the image's frame (overflow: hidden);
   data-clip="flat" skips the inner zoom. A frame whose image the CSS
   already moves (.appear-zoom, a scroll-driven scale) only gets the
   clip: two transforms on one image would fight.
   Below the fold only, once.
   Sources: A src/lib/motion.ts:679 (square, inner zoom 1.16);
   C src/scripts/motion.ts:482 (rounded, no inner zoom). The theme is
   square: A's.
   ============================================================ */
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { inFirstView, skipIntro } from "../core/guards";
import type { Kit } from "../core/kit";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-clip]";

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const FROM = "inset(12% 5% 12% 5%)"; // where the clip opens from (A)
const DURATION = 1.5; // s (A and C)
const ZOOM = 1.16; // the inner image's starting scale (A)
const START = "top 88%"; // (A and C)

export function init(kit: Kit): void {
  kit.query(hook).forEach((frame) => {
    if (skipIntro(frame) || inFirstView(frame)) return;
    const scrollTrigger = { trigger: frame, start: START, once: true };
    gsap.fromTo(
      frame,
      { clipPath: FROM },
      { clipPath: "inset(0% 0% 0% 0%)", duration: DURATION, ease: "power4.out", clearProps: "clipPath", scrollTrigger },
    );
    const img = frame.querySelector("img");
    if (!img || frame.dataset.clip === "flat" || frame.matches(".appear-zoom")) return;
    gsap.fromTo(
      img,
      { scale: ZOOM, transition: "none" },
      { scale: 1, duration: 1.8, ease: "power3.out", clearProps: "transform,transition", scrollTrigger },
    );
  });
}
