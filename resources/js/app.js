import './bootstrap';
import $ from 'jquery';
import 'datatables.net-dt';
import select2 from 'select2';
import Swal from 'sweetalert2';

window.$ = window.jQuery = $;
window.Swal = Swal;
select2($);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './users/index';
import './users/form';
import './users/alerts';
import './sections/index';
import './classes/index';
import './classes/form';
