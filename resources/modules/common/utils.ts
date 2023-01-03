import { ExtendedWindow } from "./types";

export function addEventListener(
    event: string,
    selector: string | null,
    handler: (e: Event, el: Element) => unknown,
    parent: HTMLElement = document.body
  ) {
    parent.addEventListener(event, function (this: HTMLElement, e) {
      if (!selector) return handler(e, parent);
  
      for (
        let target = e.target;
        target && target instanceof Element && target != this;
        target = target.parentNode
      ) {
        if (target.matches(selector)) {
          handler(e, target);
          break;
        }
      }
    });
  }
  
  export function w(): ExtendedWindow {
    return window as any as ExtendedWindow;
  }