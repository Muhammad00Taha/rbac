import $ from 'jquery';

const initSectionsDataTable = () => {
    const tableElement = document.getElementById('sections-table');

    if (!tableElement || $.fn.dataTable.isDataTable(tableElement)) {
        return;
    }

    const ajaxUrl = tableElement.dataset.source;
    const language = tableElement.dataset.language ? JSON.parse(tableElement.dataset.language) : undefined;

    if (!ajaxUrl) {
        console.warn('Missing data-source attribute for sections DataTable.');
        return;
    }

    $(tableElement).DataTable({
        processing: true,
        serverSide: true,
        ajax: ajaxUrl,
        order: [[0, 'asc']],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        language,
    });
};

document.addEventListener('DOMContentLoaded', initSectionsDataTable);

