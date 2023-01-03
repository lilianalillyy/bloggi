import { Naja } from "naja";

export class AnimationExtension {
  _loader: Element | null = null;

  initialize(naja: Naja) {
    document.addEventListener("DOMContentLoaded", () =>
      this.withLoader((loader) => {
        loader instanceof HTMLElement && (loader.style.opacity = "0%");
      })
    );

    naja.addEventListener("start", (e) => {
      if (e.detail.request.method.toLowerCase() !== "get") return;

      for (const snippet of document.querySelectorAll("[id^='snippet--']")) {
        if (this.isSnippetAnimated(snippet)) {
          this.withLoader(
            (loader) =>
              loader instanceof HTMLButtonElement &&
              (loader.style.opacity = "0%")
          );
          snippet.classList.add("hidden");
        }
      }
    });

    naja.snippetHandler.addEventListener(
      "beforeUpdate",
      ({ detail: { snippet } }) => {
        console.log("snipput", snippet)
        if (this.isSnippetAnimated(snippet)) {
          this.withLoader((loader) => {
            if (loader instanceof HTMLElement) {
              loader.style.opacity = "0%";
              loader.style.position = "absolute";
            }
          });
          // Wait for the CSS animation
          setTimeout(() => snippet.classList.remove("hidden"), 100);
        }
      }
    );
  }

  getLoader(): Element | null {
    if (!this._loader)
      return (this._loader = document.querySelector("[naja-loader]"));

    return this._loader;
  }

  withLoader(cb: (el: Element) => unknown) {
    const loader = this.getLoader();
    loader && cb(loader);
  }

  isSnippetAnimated(snippet: Element) {
    const attrTrue = (val: ReturnType<typeof snippet["getAttribute"]>) =>
      val === "" ?? !!val;

    let canAnimate = attrTrue(snippet.getAttribute("naja-animate"));

    if (!canAnimate) {
      const firstChild = snippet.children[0];
      if (!firstChild) return false;

      canAnimate = attrTrue(firstChild.getAttribute("naja-animate"));
    }

    return canAnimate;
  }
}
