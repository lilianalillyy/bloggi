import { initNaja } from "./naja";
import { Module, startModule } from "./modules";

import "./styles/common.css";

export class CommonModule implements Module {
  onDomLoad(): void {
    initNaja();
  }
}

startModule(new CommonModule());
