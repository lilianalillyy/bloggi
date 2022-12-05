import { Module, startModule } from '../common/modules';
import './styles/admin.scss';

export class AdminModule implements Module {

}

startModule(new AdminModule());
