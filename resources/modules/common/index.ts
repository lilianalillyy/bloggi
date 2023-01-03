import { initNaja } from "./naja";
import { Module, startModule } from "./modules";
import { initNetteForms } from "./netteForms";
import feather from "feather-icons";

import "nette-forms";

import "@popperjs/core";
import "bootstrap";

import "./styles/common.scss";

export class CommonModule implements Module {
  onDomLoad(): void {
    feather.replace();
    initNaja();
    initNetteForms();
  }
}

startModule(new CommonModule());
