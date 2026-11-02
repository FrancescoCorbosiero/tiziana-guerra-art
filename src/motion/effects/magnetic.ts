/* ============================================================
   magnetic — pulled toward the pointer, springs back on leave.
   Markup: data-magnetic[="0.35"] (how much of the pointer's offset it
   follows). A mouse only.
   Sources: C src/scripts/motion.ts:1210 (follows 35% of the pointer's
   offset, no lean, elastic return: the canonical shape here);
   A src/lib/motion.ts:1097 (16% of its own box, leans in 3D).
   ============================================================ */
import { gsap } from "gsap";
import type { Kit } from "../core/kit";

export const hook = "[data-magnetic]";

export function init(kit: Kit): void {
  if (!kit.fine) return;
  kit.query(hook).forEach((el) => {
    const strength = Number(el.dataset.magnetic) || 0.35;
    const xTo = gsap.quickTo(el, "x", { duration: 0.4, ease: "power3.out" });
    const yTo = gsap.quickTo(el, "y", { duration: 0.4, ease: "power3.out" });
    kit.on(el, "pointermove", (e) => {
      const r = el.getBoundingClientRect();
      xTo((e.clientX - (r.left + r.width / 2)) * strength);
      yTo((e.clientY - (r.top + r.height / 2)) * strength);
    });
    kit.on(el, "pointerleave", () => {
      gsap.to(el, { x: 0, y: 0, duration: 0.8, ease: "elastic.out(1, 0.4)", overwrite: true, clearProps: "transform" });
    });
  });
}
