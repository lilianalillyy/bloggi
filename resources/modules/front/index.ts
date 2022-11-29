import { Dropdown } from "bootstrap";
import { Module, startModule } from "../common/modules";

import "./styles/front.scss";

class FrontModule implements Module {
  onDomLoad(): void {
    document.querySelectorAll(".dropdown").forEach((el) => new Dropdown(el));
  }
}

startModule(new FrontModule());
