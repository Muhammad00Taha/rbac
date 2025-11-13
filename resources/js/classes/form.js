import $ from 'jquery';

const initSectionSelect2 = () => {
    const sectionSelect = $('#section_id');

    if (!sectionSelect.length) {
        return;
    }

    sectionSelect.select2({
        placeholder: 'Select a section',
        allowClear: false,
        width: '100%',
        theme: 'default',
        ajax: {
            url: '/api/sections/select2',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });
};

document.addEventListener('DOMContentLoaded', initSectionSelect2);

