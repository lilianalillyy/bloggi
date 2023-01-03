import { Module, startModule } from '../common/modules';
import { w } from '../common/utils';
import {initDatagrid} from "./datagrid";
import { initEditor } from './editor';
import './styles/admin.scss';


export class AdminModule implements Module {
    onDomLoad(): void {
        initDatagrid(w().naja);
        initEditor(w().naja)
    }
}

startModule(new AdminModule());
