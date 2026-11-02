export interface SiteConfig {
  name: string;
  logo: string;
  author: string;
  /** Nome d'arte (dati strutturati schema.org: alternateName). */
  pseudonimo: string;
  url: string;
  locale: string;
  lang: string;
  /** Motto (descrizione del sito WordPress). */
  tagline: string;
  /** Frase grande nel piè di pagina. */
  footerTagline: string;
  description: string;
  contatti: { email: string; telefono: string; whatsapp: string; luogo: string };
  social: { label: string; url: string }[];
  /** Opera mostrata a destra nel menu a tutto schermo (id = nome della cartella). */
  operaMenu: string;
  /** Pagina della privacy policy (vuoto = nessun link nel piè di pagina). */
  privacyUrl: string;
  contactFormEndpoint: string;
  mostraPrezzi: boolean;
}

/**
 * Impostazioni generali del sito (dati presi dal sito WordPress).
 * Tutto ciò che è vuoto ('' o []) viene semplicemente nascosto.
 */
export const site: SiteConfig = {
  name: 'Tiziana Guerra Art',
  logo: 'Tiziana Guerra Art',
  author: 'Tiziana Guerra',
  pseudonimo: 'Angelart',
  url: 'https://tizianaguerra.art',
  locale: 'it_IT',
  lang: 'it',

  tagline: "L'arte per me è vita e rinascita.",
  footerTagline: "Per me l'arte è vita e rinascita.",
  description:
    'Tiziana Guerra, artista autodidatta italiana. Dipinti dai colori vivaci che trasmettono emozioni positive e rinascita.',

  contatti: {
    email: 'forevertizzy@yahoo.it',
    /** Formato libero, es. '+39 333 123 4567'. */
    telefono: '',
    /** Solo cifre con prefisso internazionale, es. '393331234567'. Abilita il pulsante WhatsApp. */
    whatsapp: '',
    /** Es. 'Nova Milanese (MB)'. */
    luogo: '',
  },

  social: [{ label: 'Instagram', url: 'https://www.instagram.com/tizianaguerra.art/' }],

  operaMenu: 'la-ragazza-doro-e-caffe',

  privacyUrl: '/privacy-policy/',

  /**
   * Indirizzo a cui il modulo di contatto invia i messaggi: il micro-servizio in
   * server/contatti (inoltro via AWS SES), raggiunto tramite nginx. Vuoto = niente modulo.
   */
  contactFormEndpoint: '/api/contatti',

  /** Mostra il prezzo nelle schede quando è indicato nell'opera. */
  mostraPrezzi: true,
};

export type NavItem = { label: string; href: string; children?: { label: string; href: string }[] };

/** Menu principale (stesse voci del sito WordPress). */
export const nav: NavItem[] = [
  { label: 'Home', href: '/' },
  { label: 'Chi sono', href: '/chi-sono/' },
  {
    label: 'Pitture',
    href: '/pitture/',
    children: [
      { label: 'Acrilico', href: '/pitture/categoria/acrilico/' },
      { label: 'Spatola', href: '/pitture/categoria/spatola/' },
    ],
  },
  { label: 'Contatti', href: '/contatti/' },
  { label: 'Galleria', href: '/galleria/' },
];

/** Colonna "Website" del piè di pagina. */
export const footerNav: NavItem[] = [
  { label: 'Chi Sono', href: '/chi-sono/' },
  { label: 'Pitture', href: '/pitture/' },
  { label: 'Contatti', href: '/contatti/' },
];
