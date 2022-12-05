import { Tooltip } from "bootstrap";
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

startModule(new FrontModule());
