/* ============================================================
   split-wipe — each line of a heading is uncovered left to right.
   Markup: data-split="wipe" on a heading.
   Below the fold only, once, as the heading enters (_headings.ts).
   Sources: A src/lib/motion.ts:527; C src/scripts/motion.ts:383
   (catalog.md, status src: ported for tizianaguerra.art).
   ============================================================ */
import { gsap } from "gsap";
import type { Kit } from "../core/kit";
import { splitHeading, type HeadingMove } from "./_headings";

export const hook = '[data-split="wipe"]';

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const DURATION = 1.3; // s (A 1.3, C 1.2)
const STAGGER = 0.12; // s between lines (A)
const EASE = "power3.inOut"; // (A and C)

export const move: HeadingMove = {
  split: { type: "lines" },
  play: (split, scrollTrigger) =>
    gsap.fromTo(
      split.lines,
      { clipPath: "inset(-20% 100% -20% 0%)" },
      {
        clipPath: "inset(-20% 0% -20% 0%)",
        duration: DURATION,
        ease: EASE,
        stagger: STAGGER,
        clearProps: "clipPath",
        scrollTrigger,
      },
    ),
};

export function init(kit: Kit): void {
  kit.query(hook).forEach((el) => splitHeading(el, move));
}
