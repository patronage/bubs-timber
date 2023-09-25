import { Collapse, Select, initTE } from 'tw-elements';
import { logMessage } from './console';
import 'instant.page';

// Enable certain tw-elements
initTE({ Collapse, Select }, true); // set second parameter to true if you want to use a debugger

logMessage('you are in main.js');
