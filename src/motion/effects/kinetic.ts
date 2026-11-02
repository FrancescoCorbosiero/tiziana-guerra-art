/* ============================================================
   kinetic — a band's lines slide across, one each way, while it
   crosses the screen. Markup: data-kinetic on the band,
   data-kinetic-line="1" or "-1" on each line (a track holding its
   text twice). Scrubbed: the lines move only while the reader
   scrolls, so nothing on the page moves on its own (WCAG 2.2.2);
   the band's CSS marquee is what runs without JS.
   Source: A src/lib/landing/scenes.ts:556.
   ============================================================ */
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import type { Kit } from "../core/kit";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-kinetic]";

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const TRAVEL = 25; // % of a line's track (half a copy of its text) (A)
const SMOOTH = 0.4; // s (A)

export function init(kit: Kit): void {
  kit.query(hook).forEach((band) => {
    band.querySelectorAll<HTMLElement>("[data-kinetic-line]").forEach((line) => {
      const dir = Number(line.dataset.kineticLine) || 1;
      gsap.fromTo(
        line,
        { xPercent: dir > 0 ? 0 : -TRAVEL },
        {
          xPercent: dir > 0 ? -TRAVEL : 0,
          ease: "none",
          scrollTrigger: { trigger: band, start: "top bottom", end: "bottom top", scrub: SMOOTH },
        },
      );
    });
  });
}
