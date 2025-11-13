import $ from 'jquery';

const initClassesDataTable = () => {
    const tableElement = document.getElementById('classes-table');

    if (!tableElement || $.fn.dataTable.isDataTable(tableElement)) {
        return;
    }

    const ajaxUrl = tableElement.dataset.source;
    const language = tableElement.dataset.language ? JSON.parse(tableElement.dataset.language) : undefined;

    if (!ajaxUrl) {
        console.warn('Missing data-source attribute for classes DataTable.');
        return;
    }

    $(tableElement).DataTable({
        processing: true,
        serverSide: true,
        ajax: ajaxUrl,
        order: [[0, 'asc']],
        columns: [
            { data: 'class_name', name: 'class_name' },
            { data: 'section_name', name: 'section.name' },
            { data: 'description', name: 'description' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        language,
    });
};

document.addEventListener('DOMContentLoaded', initClassesDataTable);

