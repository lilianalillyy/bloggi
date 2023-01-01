import naja, { Naja } from "naja";
import { ForceRedirectExtension } from "./extensions/ForceRedirectExtension";
import { IconExtension } from "./extensions/IconExtension";
import { LoaderExtension } from "./extensions/LoaderExtension";

export const initNaja = (): Naja => {
  naja.registerExtension(new LoaderExtension());
  naja.registerExtension(new ForceRedirectExtension());
  naja.registerExtension(new IconExtension())
  
  naja.initialize();

  return naja;
};
