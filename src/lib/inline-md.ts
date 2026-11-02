/**
 * Markdown "in linea" minimo per testi brevi presi dal frontmatter (es. voci degli eventi):
 * **grassetto** e *corsivo*. Tutto il resto viene mostrato come testo (HTML sempre escapato).
 */
const escapeHtml = (s: string) =>
  s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

export function inlineMarkdown(testo: string): string {
  return escapeHtml(testo)
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.+?)\*/g, '<em>$1</em>');
}
