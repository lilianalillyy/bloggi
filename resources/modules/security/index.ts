import { Module, startModule } from '../common/modules';
import './styles/security.scss';

export class SecurityModule implements Module {

}

startModule(new SecurityModule());
