/* ============================================================
   lens — a magnifier follows the pointer over an image: the same
   image, zoomed, in a circle. On a painting: the brushwork and the
   palette knife up close.
   Markup: data-lens on the image's container (position: relative);
   the lens is drawn from the largest file the <picture> offers in the
   format the browser chose, and only over the image itself (not its
   passe-partout). A mouse only, desktop only; an image too small to
   magnify gets no lens. Decorative: the click still opens the zoom.
   Its ticker runs only while the lens is shown (the catalog's porting
   note on C: subscribe on enter, not for the page's lifetime).
   Source: C src/scripts/motion.ts:1307, CSS C src/styles/motion.css:140.
   ============================================================ */
import { gsap } from "gsap";
import type { Kit } from "../core/kit";

export const hook = "[data-lens]";

/* ---------- Settings: the site's voice, tuned when copying ---------- */
const ZOOM = 2.2; // magnification, at most (C 1.9)
const MIN_ZOOM = 1.4; // below this the file can't magnify: no lens
const FOLLOW = 0.22; // how fast the lens catches the pointer, per frame (C)

/** The largest candidate of the srcset the browser picked from. */
function largestSource(img: HTMLImageElement): { url: string; width: number } {
  const sets = [...(img.parentElement?.querySelectorAll("source") ?? [])].map((s) => s.srcset);
  sets.push(img.srcset);
  const chosen = sets.find((set) => set && img.currentSrc && set.includes(img.currentSrc.split("/").pop() ?? "")) ?? "";
  let best = { url: img.currentSrc, width: img.naturalWidth };
  chosen.split(",").forEach((candidate) => {
    const [url, w] = candidate.trim().split(/\s+/);
    const width = parseInt(w ?? "", 10);
    if (url && width > best.width) best = { url: new URL(url, location.href).href, width };
  });
  return best;
}

export function init(kit: Kit): void {
  if (!kit.fine) return;
  kit.media.add("(min-width: 1025px)", () => {
    const undo: (() => void)[] = [];
    kit.query(hook).forEach((root) => {
      const img = root.querySelector("img");
      if (!img) return;
      const lens = document.createElement("span");
      lens.className = "lens";
      lens.setAttribute("aria-hidden", "true");
      root.appendChild(lens);
      gsap.set(lens, { xPercent: -50, yPercent: -50, scale: 0 });

      let source: { url: string; width: number } | null = null;
      let zoom = 0;
      let shown = false;
      const target = { x: 0, y: 0 };
      const pos = { x: 0, y: 0 };
      let box = { left: 0, top: 0, width: 0, height: 0 };

      /** The image's box in the container's coordinates. */
      const measure = (): void => {
        const r = root.getBoundingClientRect();
        const i = img.getBoundingClientRect();
        box = { left: i.left - r.left, top: i.top - r.top, width: i.width, height: i.height };
      };
      const draw = (): void => {
        pos.x += (target.x - pos.x) * FOLLOW;
        pos.y += (target.y - pos.y) * FOLLOW;
        const radius = lens.offsetWidth / 2;
        gsap.set(lens, { x: pos.x, y: pos.y });
        lens.style.backgroundSize = `${box.width * zoom}px ${box.height * zoom}px`;
        lens.style.backgroundPosition = `${(-((pos.x - box.left) * zoom - radius)).toFixed(1)}px ${(-((pos.y - box.top) * zoom - radius)).toFixed(1)}px`;
      };
      const hide = (): void => {
        if (!shown) return;
        shown = false;
        gsap.to(lens, {
          scale: 0,
          duration: 0.3,
          ease: "power2.in",
          overwrite: "auto",
          onComplete: () => gsap.ticker.remove(draw),
        });
      };
      const show = (): void => {
        if (shown) return;
        source ??= largestSource(img);
        zoom = Math.min(ZOOM, source.width / Math.max(1, box.width));
        if (zoom < MIN_ZOOM) return;
        lens.style.backgroundImage = `url("${source.url}")`;
        shown = true;
        Object.assign(pos, target);
        gsap.ticker.add(draw);
        gsap.to(lens, { scale: 1, duration: 0.5, ease: "back.out(1.8)", overwrite: "auto" });
      };

      kit.on(root, "pointermove", (e) => {
        if (e.pointerType !== "mouse") return;
        measure();
        const r = root.getBoundingClientRect();
        target.x = e.clientX - r.left;
        target.y = e.clientY - r.top;
        const inside =
          target.x >= box.left && target.x <= box.left + box.width && target.y >= box.top && target.y <= box.top + box.height;
        if (inside) show();
        else hide();
      });
      kit.on(root, "pointerleave", hide);
      undo.push(() => {
        gsap.ticker.remove(draw);
        lens.remove();
      });
    });
    return () => undo.forEach((fn) => fn());
  });
}
