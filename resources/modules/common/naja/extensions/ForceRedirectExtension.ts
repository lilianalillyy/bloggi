import { Naja } from "naja";

export class ForceRedirectExtension {
  initialize(naja: Naja) {
    naja.addEventListener("complete", (event) => {
      const payload = event.detail.payload;

      // Invalid payload, ignore...
      if (!payload) {
        return;
      }

      if (payload.hasOwnProperty("forceRedirect")) {
        naja.redirectHandler.makeRedirect(
          payload.redirect ?? window.location.href,
          payload.forceRedirect
        );
      }
    });
  }
}
