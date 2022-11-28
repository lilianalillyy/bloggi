import topbar from "topbar";
import naja, { Naja } from "naja";

import "./styles/common.css";

topbar.config({
  barColors: {
    0: "#86b7fe",
    ".3": "#3d8bfd",
    "1.0": "#0d6efd",
  },
});

class LoaderExtension {
  /**
   * @param {Naja} naja
   */
  initialize(naja) {
    naja.addEventListener("start", () => topbar.show());

    naja.addEventListener("complete", () => topbar.hide());
  }
}

class ForceRedirectExtension {
  /**
   * @param {Naja} naja
   */
  initialize(naja) {
    naja.addEventListener("complete", (event) => {
      const payload = event.detail.payload;

      if (payload.hasOwnProperty("forceRedirect")) {
        naja.redirectHandler.makeRedirect(payload.redirect ?? window.location.href, payload.forceRedirect);
      }
    })
  }
}

document.addEventListener("DOMContentLoaded", function () {
  naja.registerExtension(new LoaderExtension());
  naja.registerExtension(new ForceRedirectExtension())
  naja.initialize();
});
