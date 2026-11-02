/* ============================================================
   tizianaguerra.art — the site's effects, in build order (from
   alpacode-motion src/engine/registry.ts, 7b1a203).
   The sticky stage first (it adds height: everything below measures
   after it), then the headings, the blocks and the rest. A module with
   nothing to do on a page runs one query and returns. All of them are
   small and use only ScrollTrigger and SplitText: no lazy chunk.
   ============================================================ */
import type { Effect, LazyEffect } from "./core/kit";
import * as clip from "./effects/clip";
import * as heroAway from "./effects/hero-away";
import * as hscroll from "./effects/hscroll";
import * as kinetic from "./effects/kinetic";
import * as lens from "./effects/lens";
import * as magnetic from "./effects/magnetic";
import * as reveal from "./effects/reveal";
import * as scrub from "./effects/scrub";
import * as splitLines from "./effects/split-lines";
import * as splitWipe from "./effects/split-wipe";
import * as wordmark from "./effects/wordmark";
import * as years from "./effects/years";

export const effects: Effect[] = [
  hscroll,
  splitLines,
  splitWipe,
  reveal,
  clip,
  scrub,
  kinetic,
  heroAway,
  years,
  wordmark,
  lens,
  magnetic,
];

export const lazy: LazyEffect[] = [];
