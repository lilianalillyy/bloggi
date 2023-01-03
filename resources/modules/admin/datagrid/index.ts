import { Naja } from "naja";
import { w } from "../../common/utils";
// @ts-ignore
import { createDatagrid } from "./datagrid";

const fixPerPageSubmitButton = (parent: Element = document.body) => {
  parent
    .querySelectorAll(".datagrid-per-page-submit")
    .forEach(
      (el) =>
        !el.classList.contains("btn") &&
        el.classList.add("btn", "btn-sm", "btn-secondary")
    );
};

const removeDefaultInlineAddRender = (parent: Element = document.body) => {
  parent
    .querySelectorAll("thead > tr.row-group-actions")
    .forEach((head) => head.remove());
};

const fixInlineEditButtons = (parent: Element = document.body) => {
  parent.querySelectorAll(".col-action-inline-edit").forEach((edit) =>
    edit.querySelectorAll(".btn-xs").forEach((button) => {
      button.classList.remove("btn-xs");
      button.classList.add("btn-sm");

      const replaceContents = {
        Cancel: "Zrušit",
        Save: "Uložit",
      };

      Object.keys(replaceContents).forEach(
        (key) =>
          button.getAttribute("value") === key &&
          button.setAttribute(
            "value",
            replaceContents[key as keyof typeof replaceContents]
          )
      );
    })
  );
};

const fixAll = (parent: Element = document.body) => {
  fixPerPageSubmitButton(parent);
  removeDefaultInlineAddRender(parent);
  fixInlineEditButtons(parent);
};

export const initDatagrid = (naja: Naja): void => {
  createDatagrid(naja);

  fixAll();

  w().naja.snippetHandler.addEventListener("afterUpdate", (e) =>
    fixAll(e.detail.snippet)
  );
};