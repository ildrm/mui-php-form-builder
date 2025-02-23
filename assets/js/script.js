document.addEventListener('DOMContentLoaded', () => {
    // توابع کمکی
    const toggleClass = (element, className, condition) => {
        element.classList[condition ? 'add' : 'remove'](className);
    };

    // Chip Select
    document.querySelectorAll('.mui-chip-select-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('.mui-chip-select-input');
        const chipList = wrapper.querySelector('.mui-chip-list');
        const options = JSON.parse(input.dataset.options);
        const selectedValues = [];

        // ساخت لیست پیشنهادات
        const suggestions = document.createElement('div');
        suggestions.className = 'mui-chip-suggestions';
        wrapper.appendChild(suggestions);

        function updateSuggestions(filter) {
            suggestions.innerHTML = '';
            Object.entries(options).forEach(([value, text]) => {
                if (!selectedValues.includes(value) && (!filter || text.toLowerCase().includes(filter.toLowerCase()))) {
                    const suggestion = document.createElement('div');
                    suggestion.className = 'mui-chip-suggestion';
                    suggestion.dataset.value = value;
                    suggestion.textContent = text;
                    suggestion.addEventListener('click', () => {
                        addChip(value, text);
                        input.value = '';
                        suggestions.style.display = 'none';
                    });
                    suggestions.appendChild(suggestion);
                }
            });
            suggestions.style.display = suggestions.children.length > 0 ? 'block' : 'none';
        }

        function addChip(value, text) {
            if (!selectedValues.includes(value)) {
                selectedValues.push(value);
                const chip = document.createElement('span');
                chip.className = 'mui-chip';
                chip.innerHTML = `${text}<button class="mui-chip-delete" data-value="${value}">×</button>`;
                chipList.appendChild(chip);
                chip.querySelector('.mui-chip-delete').addEventListener('click', () => {
                    selectedValues.splice(selectedValues.indexOf(value), 1);
                    chip.remove();
                });
                // اضافه کردن مقدار برای ارسال فرم
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `${input.name}[]`;
                hiddenInput.value = value;
                wrapper.appendChild(hiddenInput);
            }
        }

        input.addEventListener('input', () => {
            updateSuggestions(input.value);
        });

        input.addEventListener('focus', () => {
            updateSuggestions(input.value);
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                suggestions.style.display = 'none';
            }
        });
    });

    // Accordion
    document.querySelectorAll('.mui-accordion-summary').forEach(summary => {
        summary.addEventListener('click', () => {
            const accordion = summary.parentElement;
            toggleClass(accordion, 'expanded', !accordion.classList.contains('disabled'));
        });
    });

    // Autocomplete
    document.querySelectorAll('.mui-autocomplete').forEach(input => {
        input.addEventListener('input', () => {
            const options = JSON.parse(input.dataset.options);
            const value = input.value.toLowerCase();
            console.log('Suggestions:', options.filter(opt => opt.toLowerCase().includes(value)));
        });
    });

    // Nested List
    document.querySelectorAll('.mui-list-item').forEach(item => {
        item.addEventListener('click', e => {
            e.stopPropagation();
            const sublist = item.nextElementSibling;
            if (sublist?.classList.contains('mui-nested-sublist')) {
                sublist.style.display = sublist.style.display === 'block' ? 'none' : 'block';
            }
        });
    });

    // Tabs
    document.querySelectorAll('.mui-tabs').forEach(tabs => {
        const buttons = tabs.querySelectorAll('.mui-tab');
        const panels = tabs.querySelectorAll('.mui-tab-panel');
        buttons.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                panels.forEach(p => p.classList.add('hidden'));
                btn.classList.add('active');
                panels[index].classList.remove('hidden');
            });
        });
    });

    // Dialog
    document.querySelectorAll('.mui-dialog-close').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.mui-dialog').classList.add('hidden');
        });
    });

    // Snackbar
    document.querySelectorAll('.mui-snackbar').forEach(snack => {
        const duration = parseInt(snack.dataset.autoHide);
        if (!snack.classList.contains('hidden')) {
            setTimeout(() => snack.classList.add('hidden'), duration);
        }
        snack.querySelector('.mui-snackbar-close')?.addEventListener('click', () => {
            snack.classList.add('hidden');
        });
    });

    // Sorting & Selecting Table
    document.querySelectorAll('.mui-sorting-selecting-table .mui-table-select-all').forEach(selectAll => {
        selectAll.addEventListener('change', () => {
            const table = selectAll.closest('table');
            table.querySelectorAll('.mui-table-row-select').forEach(row => row.checked = selectAll.checked);
        });
    });

    document.querySelectorAll('.mui-table-sortable').forEach(th => {
        th.addEventListener('click', () => {
            const table = th.closest('table');
            const index = Array.from(th.parentElement.children).indexOf(th) - 1;
            const rows = Array.from(table.querySelector('tbody').rows);
            const isAsc = !th.classList.contains('sorted-asc');
            rows.sort((a, b) => {
                const aVal = a.cells[index].textContent;
                const bVal = b.cells[index].textContent;
                return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            });
            toggleClass(th, 'sorted-asc', isAsc);
            toggleClass(th, 'sorted-desc', !isAsc);
            table.querySelector('tbody').append(...rows);
        });
    });

    // Data Table Pagination
    document.querySelectorAll('.mui-data-table').forEach(table => {
        const pagination = table.nextElementSibling;
        if (pagination?.classList.contains('mui-table-pagination')) {
            const rowsPerPage = parseInt(pagination.dataset.rowsPerPage);
            const rows = table.querySelectorAll('tbody tr');
            let page = 0;
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            function updatePagination() {
                rows.forEach((row, index) => {
                    row.style.display = (index >= page * rowsPerPage && index < (page + 1) * rowsPerPage) ? '' : 'none';
                });
                pagination.innerHTML = `Page ${page + 1} of ${totalPages} <button ${page <= 0 ? 'disabled' : ''} onclick="page--; updatePagination();">Prev</button> <button ${page >= totalPages - 1 ? 'disabled' : ''} onclick="page++; updatePagination();">Next</button>`;
            }
            updatePagination();
        }
    });

    // Form Submission
    const form = document.getElementById('fullForm');
    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            alert('Form submitted to: ' + form.action);
        });
    }
});