import { Naja } from "naja";
// @ts-ignore
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

let _editors: ClassicEditor[] = [];

export const createEditor = (el: HTMLElement): Promise<ClassicEditor> =>
  ClassicEditor.create(el);

export const loadEditors = () => {
  _editors = [];

  for (const el of document.querySelectorAll("[data-iseditor]")) {
    if (!(el instanceof HTMLTextAreaElement)) return;

    createEditor(el).then((e) => _editors.push(e));
  }
};

export const initEditor = (naja: Naja) => {
  loadEditors();

  naja.uiHandler.addEventListener("interaction", () => {
    for (const editor of _editors) {
      editor.updateSourceElement();
    }
  });

  naja.addEventListener("complete", () => {
    loadEditors();
  });
};