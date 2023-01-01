import { Naja } from "naja";
import feather from "feather-icons";

export class IconExtension {
  initialize(naja: Naja) {
    feather.replace();

    naja.addEventListener("complete", () => feather.replace());
  }
}
