/*
 * Loader (Loader.astro): solo alla prima pagina della visita, mai con "riduci movimento", mai senza
 * JavaScript. Script classico e bloccante in <head>, in un file a parte (la CSP non ammette script
 * inline): la classe c'è già al primo paint, quindi il loader non lampeggia sulle pagine successive.
 */
(function () {
  try {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.sessionStorage.getItem('tg-loader')) return;
    window.sessionStorage.setItem('tg-loader', '1');
    document.documentElement.classList.add('con-loader');
  } catch (e) {
    /* sessionStorage non disponibile: niente loader */
  }
})();
