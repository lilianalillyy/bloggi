import { initNaja } from "./naja";
import { Module, startModule } from "./modules";
import feather from "feather-icons";

import "nette-forms";

import "@popperjs/core";
import "bootstrap";

import "./styles/common.scss";

export class CommonModule implements Module {
  onDomLoad(): void {
    feather.replace();
    initNaja();
  }
}

startModule(new CommonModule());
