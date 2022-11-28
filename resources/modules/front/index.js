import { Dropdown } from 'bootstrap'

import "./styles/front.scss";

document.querySelectorAll('.dropdown').forEach((el) => new Dropdown(el))
