import { Module, startModule } from '../common/modules';
import './styles/admin.scss';

import "nette-forms";

export class AdminModule implements Module {

}

startModule(new AdminModule());
