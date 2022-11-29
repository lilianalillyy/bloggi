import { Naja } from "naja";
import { $topbar } from "../../topbar";

export class LoaderExtension {
  initialize(naja: Naja) {
    naja.addEventListener("start", () => $topbar.show());

    naja.addEventListener("complete", () => $topbar.hide());
  }
}
