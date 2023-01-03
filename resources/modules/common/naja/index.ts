// import naja, { Naja } from "naja";
// import { w } from "../utils";
// import { ForceRedirectExtension } from "./extensions/ForceRedirectExtension";
// import { IconExtension } from "./extensions/IconExtension";
// import { LoaderExtension } from "./extensions/LoaderExtension";

// export const initNaja = (): Naja => {
//   naja.registerExtension(new LoaderExtension());
//   naja.registerExtension(new ForceRedirectExtension());
//   naja.registerExtension(new IconExtension())
  
//   naja.initialize();

//   w().naja = naja;

//   return naja;
// };
// 
import naja, { Naja } from "naja";
import { w } from "../utils";
import { LoaderExtension } from "./extensions/LoaderExtension";
import { ForceRedirectExtension } from "./extensions/ForceRedirectExtension";
import { IconExtension } from "./extensions/IconExtension";
import { AnimationExtension } from "./extensions/AnimationExtension";

export const initNaja = (): Naja => {
  naja.registerExtension(new LoaderExtension());
  naja.registerExtension(new ForceRedirectExtension());
  naja.registerExtension(new IconExtension())
  naja.registerExtension(new AnimationExtension())

  naja.initialize();

  w().naja = naja;
  return naja;
};