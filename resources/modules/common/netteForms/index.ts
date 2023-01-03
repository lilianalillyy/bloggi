/** @ts-ignore */
import Nette from "nette-forms"
import { w } from "../utils";

export const initNetteForms = () => {
    Nette.initOnLoad();
    w().Nette = Nette;
}