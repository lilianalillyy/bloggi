import "./styles/app.scss";
import topbar from "topbar";
import naja, { Naja } from "naja";
import { Dropdown } from 'bootstrap'

document.querySelectorAll('.dropdown').forEach((el) => new Dropdown(el))

topbar.config({
  barColors: {
    '0': "#86b7fe",
    ".3": "#3d8bfd",
    "1.0": "#0d6efd"
  }
})

class LoaderExtension {
  /**
   * @param {Naja} naja
   */
  initialize(naja) {
    naja.addEventListener('start', () => topbar.show());

    naja.addEventListener('complete', () => topbar.hide());
  }
}

document.addEventListener('DOMContentLoaded', function () {
  naja.registerExtension(new LoaderExtension())
  naja.initialize()
});
