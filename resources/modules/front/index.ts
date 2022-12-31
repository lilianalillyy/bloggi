import { Dropdown, Tooltip } from "bootstrap";
import { Module, startModule } from "../common/modules";

import "./styles/front.scss";
import "@popperjs/core";

class FrontModule implements Module {
  onDomLoad() {
    /**
     * Enable tooltips in the front bar
     */
    document.querySelectorAll('.front-bar [data-bs-toggle="tooltip"]').forEach(el => new Tooltip(el).enable())

    
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.dropdown-toggle').forEach(el => new Dropdown(el))
})

startModule(new FrontModule());
