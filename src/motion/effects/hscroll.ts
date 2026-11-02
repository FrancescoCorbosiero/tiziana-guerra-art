/* ============================================================
   hscroll — a horizontal gallery moved by the vertical scroll, with
   its progress (tier 2).
   Markup contract: [data-hscroll] on the section, holding a
   [data-hscroll-stage] that holds the [data-hscroll-track]; optional
   [data-hscroll-current] (the counter), [data-hscroll-prev] and
   [data-hscroll-next] (buttons), and --p (0–1) on the section for a
   progress bar.
   Desktop only: the section grows by the track's overflow (--hscroll-dist)
   and its stage sticks for that long while the scroll moves the track
   (D6: a CSS sticky stage and a scrubbed tween, no GSAP pin). The
   buttons then glide the page to the next work, and the counter
   follows the scroll. Elsewhere, and without JS or under reduced
   motion, the track is the native swipe carousel (scroll-snap).
   Source: C src/scripts/motion.ts:657 (pinned with GSAP; here a
   sticky stage, as alpacode's landing scenes do), CSS
   C src/styles/sections.css:223.
   ============================================================ */
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import type { Kit } from "../core/kit";
import { scrollToTarget } from "../core/scroll";

gsap.registerPlugin(ScrollTrigger);

export const hook = "[data-hscroll]";

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const DESKTOP = "(min-width: 1025px)";
const SMOOTH = 0.6; // s the track takes to catch up with the scroll (C)

export function init(kit: Kit): void {
  kit.query(hook).forEach((sec) => {
    const stage = sec.querySelector<HTMLElement>("[data-hscroll-stage]");
    const track = sec.querySelector<HTMLElement>("[data-hscroll-track]");
    if (!stage || !track) return;
    const slides = [...track.children] as HTMLElement[];
    const current = sec.querySelector<HTMLElement>("[data-hscroll-current]");
    const prev = sec.querySelector<HTMLButtonElement>("[data-hscroll-prev]");
    const next = sec.querySelector<HTMLButtonElement>("[data-hscroll-next]");

    kit.media.add(DESKTOP, () => {
      sec.classList.add("is-pinned");
      track.scrollLeft = 0; // the swipe carousel may have been scrolled before (a resize)
      // Measured from layout, again at every refresh (the stage's width,
      // the slides' size and the fonts can all change it).
      const dist = (): number => Math.max(0, track.scrollWidth - stage.clientWidth);
      const setLength = (): void => sec.style.setProperty("--hscroll-dist", `${dist()}px`);
      setLength();

      let index = -1;
      const show = (progress: number): void => {
        sec.style.setProperty("--p", progress.toFixed(4));
        const i = Math.round(progress * (slides.length - 1));
        if (i === index) return;
        index = i;
        if (current) current.textContent = String(i + 1).padStart(2, "0");
        if (prev) prev.disabled = i <= 0;
        if (next) next.disabled = i >= slides.length - 1;
      };

      const tween = gsap.fromTo(
        track,
        { x: 0 },
        {
          x: () => -dist(),
          ease: "none",
          scrollTrigger: {
            trigger: sec,
            start: "top top",
            end: "bottom bottom",
            scrub: SMOOTH,
            invalidateOnRefresh: true,
            onRefreshInit: setLength,
            onUpdate: (self) => show(self.progress),
          },
        },
      );
      show(0);

      // The buttons glide the page to the work before or after.
      const goTo = (i: number): void => {
        const st = tween.scrollTrigger;
        if (!st) return;
        const n = Math.min(slides.length - 1, Math.max(0, i));
        scrollToTarget(st.start + (st.end - st.start) * (n / Math.max(1, slides.length - 1)));
      };
      const step = (delta: number): void => goTo(Math.round((tween.scrollTrigger?.progress ?? 0) * (slides.length - 1)) + delta);
      if (prev) kit.on(prev, "click", () => step(-1));
      if (next) kit.on(next, "click", () => step(1));
      // Keyboard: a work reached with Tab may sit outside the stage; bring the
      // page to it (the stage itself never scrolls: overflow: clip in the CSS).
      kit.on(track, "focusin", (e) => {
        const i = slides.findIndex((s) => s.contains(e.target as Node));
        if (i >= 0 && i !== index) goTo(i);
      });

      return () => {
        sec.classList.remove("is-pinned");
        ["--hscroll-dist", "--p"].forEach((v) => sec.style.removeProperty(v));
      };
    });
  });
}
