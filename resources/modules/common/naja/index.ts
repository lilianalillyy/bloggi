import naja, { Naja } from "naja";
import { ForceRedirectExtension } from "./extensions/ForceRedirectExtension";
import { LoaderExtension } from "./extensions/LoaderExtension";

export const initNaja = (): Naja => {
  naja.registerExtension(new LoaderExtension());
  naja.registerExtension(new ForceRedirectExtension());
  naja.initialize();

  return naja;
};
