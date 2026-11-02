export interface SiteConfig {
  name: string;
  logo: string;
  author: string;
  url: string;
  locale: string;
  lang: string;
  tagline: string;
  description: string;
  contatti: { email: string; telefono: string; whatsapp: string; luogo: string };
  social: { label: string; url: string }[];
  contactFormEndpoint: string;
  mostraPrezzi: boolean;
}

/**
 * Impostazioni generali del sito.
 * Tutto ciò che è vuoto ('' o []) viene semplicemente nascosto.
 */
export const site: SiteConfig = {
  name: 'Tiziana Guerra Art',
  /** Testo del logo nell'header. */
  logo: 'Tiziana Guerra Art',
  author: 'Tiziana Guerra',
  url: 'https://tizianaguerra.art',
  locale: 'it_IT',
  lang: 'it',

  /** Sottotitolo usato in homepage e nei metadati. */
  tagline: 'Pittura',
  description:
    'Tiziana Guerra Art: dipinti originali, paesaggi, ritratti e opere astratte. Scopri le pitture e richiedi informazioni sulle opere.',

  contatti: {
    // ⚠️ DA VERIFICARE: indirizzo provvisorio, sostituire con quello reale.
    email: 'info@tizianaguerra.art',
    /** Formato libero, es. '+39 333 123 4567'. */
    telefono: '',
    /** Solo cifre con prefisso internazionale, es. '393331234567'. Abilita il pulsante WhatsApp. */
    whatsapp: '',
    /** Es. 'Piacenza, Italia'. */
    luogo: '',
  },

  social: [
    // { label: 'Instagram', url: 'https://www.instagram.com/…' },
    // { label: 'Facebook', url: 'https://www.facebook.com/…' },
  ],

  /**
   * Modulo di contatto (facoltativo). Il sito è statico: per ricevere i messaggi serve un
   * servizio esterno (Formspree, Web3Forms, Getform…) o un piccolo endpoint sul VPS.
   * Se vuoto, la pagina Contatti mostra solo email / telefono / WhatsApp.
   */
  contactFormEndpoint: '',

  /** Mostra il prezzo nelle schede quando è indicato nell'opera. */
  mostraPrezzi: true,
};

export type NavItem = { label: string; href: string };

/** Menu principale (stesso ordine del sito WordPress). */
export const nav: NavItem[] = [
  { label: 'Home', href: '/' },
  { label: 'Chi sono', href: '/chi-sono/' },
  { label: 'Pitture', href: '/pitture/' },
  { label: 'Contatti', href: '/contatti/' },
  { label: 'Galleria', href: '/galleria/' },
];
