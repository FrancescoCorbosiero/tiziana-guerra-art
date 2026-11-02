/* ============================================================
   years — a timeline's years light up as the reader reaches them:
   the year whose events are being read turns dark and the theme's
   yellow brush is drawn under it; the others stay soft.
   Markup: data-years on the timeline, data-year on each year's group,
   data-year-mark on what gets the class (a .brush, whose stroke the
   site's CSS draws on .is-active).
   Not in the catalog: a site-specific cousin of `rail` (A
   src/lib/motion.ts:740, C src/scripts/motion.ts:968), which lights a
   rail's steps as the scroll passes them. Without JS or under reduced
   motion every year is simply dark.
   ============================================================ */
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { gsap } from "gsap";
import type { Kit } from "../core/kit";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-years]";

/* ---------- Settings ---------- */
const READING = { start: "top 62%", end: "bottom 38%" }; // the band of the screen being read

export function init(kit: Kit): void {
  kit.query(hook).forEach((timeline) => {
    timeline.classList.add("is-tracking");
    kit.cleanup(() => timeline.classList.remove("is-tracking"));
    timeline.querySelectorAll<HTMLElement>("[data-year]").forEach((group) => {
      const mark = group.querySelector<HTMLElement>("[data-year-mark]") ?? group;
      ScrollTrigger.create({
        trigger: group,
        ...READING,
        toggleClass: { targets: mark, className: "is-active" },
      });
    });
  });
}
