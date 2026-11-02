/**
 * Overlay a tutto schermo (menu, ricerca, zoom) basati sulla Popover API.
 * Funzionano anche senza JavaScript; questo script li rende "modali":
 * - mentre un overlay è aperto il resto della pagina diventa inerte
 *   (niente focus né lettura da screen reader dietro l'overlay);
 * - il focus entra nell'overlay all'apertura e torna al pulsante d'origine alla chiusura.
 */
const resiInerti = new Set<Element>();

function sblocca() {
  for (const el of resiInerti) el.removeAttribute('inert');
  resiInerti.clear();
}

for (const overlay of document.querySelectorAll<HTMLElement>('.overlay[popover]')) {
  let focusPrecedente: HTMLElement | null = null;

  overlay.addEventListener('beforetoggle', (event) => {
    if ((event as ToggleEvent).newState === 'open') {
      focusPrecedente = document.activeElement instanceof HTMLElement ? document.activeElement : null;
      sblocca();
      for (const el of document.body.children) {
        if (el !== overlay && !el.contains(overlay) && !el.hasAttribute('inert') && el.tagName !== 'SCRIPT') {
          el.setAttribute('inert', '');
          resiInerti.add(el);
        }
      }
      overlay.setAttribute('aria-modal', 'true');
    } else {
      sblocca();
      overlay.removeAttribute('aria-modal');
    }
  });

  overlay.addEventListener('toggle', (event) => {
    if ((event as ToggleEvent).newState === 'open') {
      if (!overlay.contains(document.activeElement)) {
        const target =
          overlay.querySelector<HTMLElement>('[autofocus]') ?? overlay.querySelector<HTMLElement>('.overlay-close');
        target?.focus({ preventScroll: true });
      }
    } else {
      const focusPerso = !document.activeElement || document.activeElement === document.body;
      if (focusPrecedente?.isConnected && focusPerso) focusPrecedente.focus({ preventScroll: true });
      focusPrecedente = null;
    }
  });
}

/**
 * Navigando da un overlay aperto (es. una voce del menu, un risultato della ricerca)
 * la transizione animata tra le pagine non serve — l'overlay copre già tutto — e in
 * Chrome può interrompersi con un errore: in questo caso la si salta.
 */
type PageSwap = Event & { viewTransition?: { skipTransition(): void } | null };
window.addEventListener('pageswap', (event) => {
  const { viewTransition } = event as PageSwap;
  if (viewTransition && document.querySelector('.overlay:popover-open')) viewTransition.skipTransition();
});
