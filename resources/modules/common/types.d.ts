import { Naja } from "naja";

export interface ExtendedWindow extends Window {
  Nette: Nette;
  naja: Naja;
}

export interface Nette {
  formErrors: [];
  version: string;
  invalidNumberMessage: string;
  onDocumentReady: (cb: () => unknown) => void;
  getValue: <T = any>(elem: Element) => T | null;
  getEffectiveValue: <T = any>(elem: Element, filter: boolean) => T | "" | null;
  validateControl: (elem: Element) => boolean;
}