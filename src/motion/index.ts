/* ============================================================
   The page's motion script (alpacode-motion src/engine/index.ts).
   BaseLayout loads it once per page: this site has no ClientRouter,
   every navigation is a new document (with a native view transition),
   so the core starts at DOMContentLoaded each time.
   ============================================================ */
import { start } from "./core";
import { effects, lazy } from "./registry";

start(effects, lazy);
