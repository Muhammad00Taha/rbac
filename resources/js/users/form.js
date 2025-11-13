import $ from 'jquery';

const initRoleSelect2 = () => {
    const roleSelect = $('#role');

    if (!roleSelect.length) {
        return;
    }

    roleSelect.select2({
        placeholder: 'Select a role',
        allowClear: true,
        width: '100%',
        theme: 'default'
    });
};

document.addEventListener('DOMContentLoaded', initRoleSelect2);

