import { Collapse, Select, Popover, Offcanvas, Animate, initTE } from 'tw-elements';

export function te() {
  initTE({ Collapse, Select, Offcanvas, Animate }, true); // set second parameter to true if you want to use a debugger
}
