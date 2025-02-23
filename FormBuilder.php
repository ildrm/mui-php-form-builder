<?php

class FormBuilder {
    private const DEFAULT_FORM_ID = 'myForm';
    private const DEFAULT_LOCALE = 'fa';
    private const DEFAULT_METHOD = 'POST';
    private const DEFAULT_COLUMNS = 1;

    private array $elements = [];
    private string $formId;
    private string $formAction;
    private string $formMethod;
    private string $locale;
    private string $direction;
    private array $translations;
    private int $columns;

    public function __construct(string $formId = self::DEFAULT_FORM_ID, string $locale = self::DEFAULT_LOCALE) {
        $this->formId = $formId;
        $this->formAction = '';
        $this->formMethod = self::DEFAULT_METHOD;
        $this->columns = self::DEFAULT_COLUMNS;
        $this->setLocale($locale);
    }

    public function setLocale(string $locale): void {
        $this->locale = $locale;
        $this->direction = in_array($locale, ['fa', 'ar']) ? 'rtl' : 'ltr';
        $this->translations = $this->loadTranslations($locale);
    }

    public function configureForm(array $config): void {
        $defaults = [
            'action' => '',
            'method' => self::DEFAULT_METHOD,
            'columns' => self::DEFAULT_COLUMNS,
        ];
        $config = array_merge($defaults, $config);
        $this->formAction = $config['action'];
        $this->formMethod = strtoupper($config['method']);
        $this->columns = max(1, min(12, (int)$config['columns']));
    }

    private function loadTranslations(string $locale): array {
        $translations = [
            'fa' => [
                'required' => 'اجباری',
                'submit' => 'ارسال',
                'yes' => 'بله',
                'no' => 'خیر',
                'loading' => 'در حال بارگذاری...',
                'error' => 'خطا',
                'close' => 'بستن',
                'open' => 'باز کردن',
            ],
            'en' => [
                'required' => 'Required',
                'submit' => 'Submit',
                'yes' => 'Yes',
                'no' => 'No',
                'loading' => 'Loading...',
                'error' => 'Error',
                'close' => 'Close',
                'open' => 'Open',
            ],
        ];
        return $translations[$locale] ?? $translations['en'];
    }

    private function translate(string $key): string {
        return $this->translations[$key] ?? $key;
    }

    public function addTextField(string $label, string $name, string $id, array $props = []): void {
        $this->addElement('textField', $label, $name, $id, $props, ['type' => 'text', 'variant' => 'outlined', 'color' => 'primary', 'size' => 'medium']);
    }

    public function addSelect(string $label, string $name, string $id, array $options = [], array $props = []): void {
        $this->addElement('select', $label, $name, $id, $props, ['variant' => 'outlined'], ['options' => $options]);
    }

    public function addCheckbox(string $label, string $name, string $id, array $props = []): void {
        $this->addElement('checkbox', $label, $name, $id, $props, ['value' => '1', 'color' => 'primary', 'size' => 'medium']);
    }

    public function addRadioGroup(string $label, string $name, string $id, array $options = [], array $props = []): void {
        $this->addElement('radioGroup', $label, $name, $id, $props, ['color' => 'primary'], ['options' => $options]);
    }

    public function addSwitch(string $label, string $name, string $id, array $props = []): void {
        $this->addElement('switch', $label, $name, $id, $props, ['value' => '1', 'color' => 'primary', 'size' => 'medium']);
    }

    public function addSlider(string $label, string $name, string $id, array $props = []): void {
        $this->addElement('slider', $label, $name, $id, $props, ['min' => 0, 'max' => 100, 'step' => 1, 'defaultValue' => 50, 'color' => 'primary', 'valueLabelDisplay' => 'auto']);
    }

    public function addDatePicker(string $label, string $name, string $id, array $props = []): void {
        $this->addElement('datePicker', $label, $name, $id, $props, ['format' => $this->locale === 'fa' ? 'YYYY/MM/DD' : 'MM/DD/YYYY']);
    }

    public function addAutocomplete(string $label, string $name, string $id, array $options = [], array $props = []): void {
        $this->addElement('autocomplete', $label, $name, $id, $props, ['variant' => 'outlined'], ['options' => $options]);
    }

    public function addButton(string $label, string $type = 'submit', array $props = []): void {
        $this->addElement('button', $label, '', '', $props, ['variant' => 'contained', 'color' => 'primary', 'size' => 'medium', 'buttonType' => $type]);
    }

    public function addAccordion(string $summary, string $id, string $content = '', array $props = []): void {
        $this->addElement('accordion', $summary, '', $id, $props, ['elevation' => 1], ['content' => $content]);
    }

    public function addAlert(string $title, string $id, string $message, array $props = []): void {
        $this->addElement('alert', $title, '', $id, $props, ['severity' => 'info', 'variant' => 'standard'], ['message' => $message]);
    }

    public function addCard(string $id, string $content = '', array $props = []): void {
        $this->addElement('card', '', '', $id, $props, ['elevation' => 1, 'variant' => 'elevation'], ['content' => $content]);
    }

    public function addTabs(string $id, array $tabs = [], array $props = []): void {
        $this->addElement('tabs', '', '', $id, $props, ['value' => 0, 'variant' => 'standard', 'scrollButtons' => 'auto'], ['tabs' => $tabs]);
    }

    public function addDialog(string $title, string $id, string $content = '', array $props = []): void {
        $this->addElement('dialog', $title, '', $id, $props, [], ['content' => $content]);
    }

    public function addSnackbar(string $id, string $message, array $props = []): void {
        $this->addElement('snackbar', '', '', $id, $props, ['severity' => 'info', 'autoHideDuration' => 6000], ['message' => $message]);
    }

    public function addCheckmarksSelect(string $label, string $name, string $id, array $options = [], array $props = []): void {
        $this->addElement('checkmarksSelect', $label, $name, $id, $props, ['multiple' => true, 'variant' => 'outlined'], ['options' => $options]);
    }

    public function addChipSelect(string $label, string $name, string $id, array $options = [], array $props = []): void {
        $this->addElement('chipSelect', $label, $name, $id, $props, ['variant' => 'outlined', 'multiple' => true], ['options' => $options]);
    }

    public function addNestedList(string $id, array $items = [], array $props = []): void {
        $this->addElement('nestedList', '', '', $id, $props, ['collapsed' => false], ['items' => $items]);
    }

    public function addBasicTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('basicTable', '', '', $id, $props, ['bordered' => true], ['columns' => $columns, 'rows' => $rows]);
    }

    public function addDataTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('dataTable', '', '', $id, $props, ['pagination' => true, 'rowsPerPage' => 5], ['columns' => $columns, 'rows' => $rows]);
    }

    public function addDenseTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('denseTable', '', '', $id, $props, ['dense' => true], ['columns' => $columns, 'rows' => $rows]);
    }

    public function addSortingSelectingTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('sortingSelectingTable', '', '', $id, $props, ['sortable' => true, 'selectable' => true], ['columns' => $columns, 'rows' => $rows]);
    }

    public function addSpanningTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('spanningTable', '', '', $id, $props, ['spanning' => true], ['columns' => $columns, 'rows' => $rows]);
    }

    public function addVirtualizedTable(string $id, array $columns = [], array $rows = [], array $props = []): void {
        $this->addElement('virtualizedTable', '', '', $id, $props, ['height' => '400px', 'rowHeight' => 50], ['columns' => $columns, 'rows' => $rows]);
    }

    private function addElement(string $type, string $label, string $name, string $id, array $props, array $defaultProps = [], array $extraData = []): void {
        $defaultCommonProps = ['required' => false, 'disabled' => false];
        $this->elements[] = [
            'type' => $type,
            'label' => $label,
            'name' => $name,
            'id' => $id,
            'props' => array_merge($defaultCommonProps, $defaultProps, $props),
            'extra' => $extraData,
        ];
    }

    public function render(): string {
        $html = "<form id='{$this->formId}' action='{$this->formAction}' method='{$this->formMethod}' class='form-container mui-grid' dir='{$this->direction}'>\n";
        $html .= "<div class='mui-grid-row'>\n";
        
        $columnWidth = floor(12 / $this->columns);
        $currentColumn = 0;

        foreach ($this->elements as $element) {
            if ($currentColumn >= $this->columns) {
                $html .= "</div>\n<div class='mui-grid-row'>\n";
                $currentColumn = 0;
            }
            $html .= "<div class='mui-grid-item mui-col-{$columnWidth}'>\n";
            $html .= $this->renderElement($element);
            $html .= "</div>\n";
            $currentColumn++;
        }

        $html .= "</div>\n</form>\n";
        return $html;
    }

    private function renderElement(array $element): string {
        $attributes = $this->getCommonAttributes($element);
        $html = "<div class='mui-field'>\n";

        switch ($element['type']) {
            case 'textField':
                $html .= $this->renderLabel($element);
                $html .= "<input {$attributes['string']} type='{$element['props']['type']}' class='mui-textfield mui-textfield--{$element['props']['variant']} mui-textfield--{$element['props']['color']} mui-textfield--{$element['props']['size']}' />\n";
                break;

            case 'select':
            case 'checkmarksSelect':
                $html .= $this->renderLabel($element);
                $multiple = isset($element['props']['multiple']) && $element['props']['multiple'] ? 'multiple' : '';
                $html .= "<select {$attributes['string']} class='mui-{$element['type']} mui-select--{$element['props']['variant']}' {$multiple}>\n";
                $html .= $this->renderOptions($element['extra']['options']);
                $html .= "</select>\n";
                break;

            case 'chipSelect':
                $html .= $this->renderLabel($element);
                $html .= "<div class='mui-chip-select-wrapper' id='chip-wrapper-{$element['id']}'>\n";
                $html .= "<input {$attributes['string']} type='text' class='mui-chip-select-input mui-textfield mui-textfield--{$element['props']['variant']}' data-options='" . json_encode($element['extra']['options']) . "' />\n";
                $html .= "<div class='mui-chip-list'></div>\n";
                $html .= "</div>\n";
                break;

            case 'checkbox':
            case 'switch':
                $checked = isset($element['props']['checked']) && $element['props']['checked'] ? 'checked' : '';
                $html .= "<label class='mui-{$element['type']}-label'>\n";
                $html .= "<input {$attributes['string']} type='checkbox' class='mui-{$element['type']} mui-{$element['type']}--{$element['props']['color']} mui-{$element['type']}--{$element['props']['size']}' {$checked} />\n";
                $html .= "{$element['label']}\n</label>\n";
                break;

            case 'radioGroup':
                $html .= "<fieldset class='mui-radio-group' " . (isset($element['props']['row']) && $element['props']['row'] ? "data-row='true'" : '') . ">\n";
                $html .= "<legend>{$element['label']}</legend>\n";
                foreach ($element['extra']['options'] as $value => $text) {
                    $checked = (isset($element['props']['defaultValue']) && $value === $element['props']['defaultValue']) ? 'checked' : '';
                    $html .= "<label class='mui-radio-label'><input type='radio' name='{$element['name']}' value='{$value}' class='mui-radio mui-radio--{$element['props']['color']}' {$checked} {$attributes['disabled']} />{$text}</label>\n";
                }
                $html .= "</fieldset>\n";
                break;

            case 'slider':
                $html .= $this->renderLabel($element);
                $html .= "<input {$attributes['string']} type='range' class='mui-slider mui-slider--{$element['props']['color']}' min='{$element['props']['min']}' max='{$element['props']['max']}' step='{$element['props']['step']}' value='{$element['props']['defaultValue']}' data-value-label='{$element['props']['valueLabelDisplay']}' />\n";
                break;

            case 'datePicker':
                $html .= $this->renderLabel($element);
                $html .= "<input {$attributes['string']} type='date' class='mui-datepicker' data-format='{$element['props']['format']}' />\n";
                break;

            case 'autocomplete':
                $html .= $this->renderLabel($element);
                $freeSolo = isset($element['props']['freeSolo']) ? ($element['props']['freeSolo'] ? 'true' : 'false') : 'false';
                $multiple = isset($element['props']['multiple']) ? ($element['props']['multiple'] ? 'true' : 'false') : 'false';
                $html .= "<input {$attributes['string']} type='text' class='mui-autocomplete mui-autocomplete--{$element['props']['variant']}' data-options='" . json_encode($element['extra']['options']) . "' data-free-solo='{$freeSolo}' data-multiple='{$multiple}' />\n";
                break;

            case 'button':
                $fullWidth = isset($element['props']['fullWidth']) && $element['props']['fullWidth'] ? 'mui-btn--full-width' : '';
                $html .= "<button type='{$element['props']['buttonType']}' class='mui-btn mui-btn--{$element['props']['variant']} mui-btn--{$element['props']['color']} mui-btn--{$element['props']['size']} {$fullWidth}' {$attributes['disabled']}>{$element['label']}</button>\n";
                break;

            case 'accordion':
                $expanded = isset($element['props']['expanded']) && $element['props']['expanded'] ? 'expanded' : '';
                $html .= "<div class='mui-accordion mui-accordion--elevation-{$element['props']['elevation']} {$expanded} {$attributes['disabled']}' id='{$element['id']}'>\n";
                $html .= "<div class='mui-accordion-summary'>{$element['label']}</div>\n";
                $html .= "<div class='mui-accordion-details'>{$element['extra']['content']}</div>\n";
                $html .= "</div>\n";
                break;

            case 'alert':
                $closable = isset($element['props']['closable']) && $element['props']['closable'] ? "<button class='mui-alert-close'>{$this->translate('close')}</button>" : '';
                $html .= "<div class='mui-alert mui-alert--{$element['props']['severity']} mui-alert--{$element['props']['variant']}' id='{$element['id']}'>\n";
                $html .= "<strong>{$element['label']}</strong> {$element['extra']['message']}{$closable}\n";
                $html .= "</div>\n";
                break;

            case 'card':
                $html .= "<div class='mui-card mui-card--{$element['props']['variant']}-{$element['props']['elevation']}' id='{$element['id']}'>\n";
                $html .= "{$element['extra']['content']}\n";
                $html .= "</div>\n";
                break;

            case 'tabs':
                $html .= "<div class='mui-tabs' id='{$element['id']}' data-value='{$element['props']['value']}' data-scroll-buttons='{$element['props']['scrollButtons']}'>\n";
                $html .= "<div class='mui-tabs-nav mui-tabs--{$element['props']['variant']}'>\n";
                foreach ($element['extra']['tabs'] as $index => $tab) {
                    $active = $index == $element['props']['value'] ? 'active' : '';
                    $html .= "<button class='mui-tab {$active}' data-tab='{$index}'>{$tab['label']}</button>\n";
                }
                $html .= "</div>\n";
                foreach ($element['extra']['tabs'] as $index => $tab) {
                    $active = $index == $element['props']['value'] ? '' : 'hidden';
                    $html .= "<div class='mui-tab-panel {$active}' data-panel='{$index}'>{$tab['content']}</div>\n";
                }
                $html .= "</div>\n";
                break;

            case 'dialog':
                $open = isset($element['props']['open']) && $element['props']['open'] ? '' : 'hidden';
                $fullScreen = isset($element['props']['fullScreen']) && $element['props']['fullScreen'] ? 'mui-dialog--full-screen' : '';
                $html .= "<div class='mui-dialog {$open} {$fullScreen}' id='{$element['id']}'>\n";
                $html .= "<div class='mui-dialog-content'>\n";
                $html .= "<h2>{$element['label']}</h2>\n";
                $html .= "<div>{$element['extra']['content']}</div>\n";
                $html .= "<button class='mui-dialog-close'>{$this->translate('close')}</button>\n";
                $html .= "</div>\n";
                $html .= "</div>\n";
                break;

            case 'snackbar':
                $open = isset($element['props']['open']) && $element['props']['open'] ? '' : 'hidden';
                $html .= "<div class='mui-snackbar {$open} mui-snackbar--{$element['props']['severity']}' id='{$element['id']}' data-auto-hide='{$element['props']['autoHideDuration']}'>\n";
                $html .= "<span>{$element['extra']['message']}</span>\n";
                $html .= "<button class='mui-snackbar-close'>{$this->translate('close')}</button>\n";
                $html .= "</div>\n";
                break;

            case 'nestedList':
                $collapsed = isset($element['props']['collapsed']) && $element['props']['collapsed'] ? 'collapsed' : '';
                $html .= "<ul class='mui-nested-list {$collapsed}' id='{$element['id']}'>\n";
                foreach ($element['extra']['items'] as $item) {
                    $html .= "<li><div class='mui-list-item'>{$item['label']}</div>\n";
                    if (!empty($item['children'])) {
                        $html .= "<ul class='mui-nested-sublist'>\n";
                        foreach ($item['children'] as $child) {
                            $html .= "<li class='mui-list-item'>{$child}</li>\n";
                        }
                        $html .= "</ul>\n";
                    }
                    $html .= "</li>\n";
                }
                $html .= "</ul>\n";
                break;

            case 'basicTable':
            case 'dataTable':
            case 'denseTable':
            case 'sortingSelectingTable':
            case 'spanningTable':
                $html .= $this->renderTable($element);
                break;

            case 'virtualizedTable':
                $html .= "<div class='mui-virtualized-table' id='{$element['id']}' style='height: {$element['props']['height']}; overflow-y: auto;'>\n";
                $html .= $this->renderTable($element);
                $html .= "</div>\n";
                break;
        }
        $html .= "</div>\n";
        return $html;
    }

    private function renderLabel(array $element): string {
        $required = $element['props']['required'] ? " <span class='mui-required'>{$this->translate('required')}</span>" : '';
        return "<label for='{$element['id']}'>{$element['label']}{$required}</label>\n";
    }

    private function renderOptions(array $options): string {
        $html = '';
        foreach ($options as $value => $text) {
            $html .= "<option value='{$value}'>{$text}</option>\n";
        }
        return $html;
    }

    private function getCommonAttributes(array $element): array {
        $attributes = [
            'id' => "id='{$element['id']}'",
            'name' => "name='{$element['name']}'",
            'required' => $element['props']['required'] ? 'required' : '',
            'disabled' => $element['props']['disabled'] ? 'disabled' : '',
            'placeholder' => !empty($element['props']['placeholder']) ? "placeholder='{$element['props']['placeholder']}'" : '',
        ];
        return [
            'string' => implode(' ', array_filter($attributes)),
            'disabled' => $attributes['disabled'],
        ];
    }

    private function renderTable(array $element): string {
        $classes = "mui-table mui-{$element['type']}";
        if ($element['type'] === 'basicTable' && $element['props']['bordered']) {
            $classes .= ' mui-table--bordered';
        }

        $html = "<table class='{$classes}' id='{$element['id']}'>\n";
        $html .= "<thead><tr>\n";
        
        if ($element['type'] === 'sortingSelectingTable') {
            $html .= "<th><input type='checkbox' class='mui-table-select-all'></th>\n";
        }
        
        foreach ($element['extra']['columns'] as $col) {
            $sortable = $element['type'] === 'sortingSelectingTable' ? 'mui-table-sortable' : '';
            $html .= "<th class='{$sortable}'>{$col}</th>\n";
        }
        $html .= "</tr></thead>\n<tbody>\n";

        foreach ($element['extra']['rows'] as $row) {
            $html .= "<tr>\n";
            if ($element['type'] === 'sortingSelectingTable') {
                $html .= "<td><input type='checkbox' class='mui-table-row-select'></td>\n";
            }
            foreach ($row as $cell) {
                if (is_array($cell) && isset($cell['colspan'])) {
                    $html .= "<td colspan='{$cell['colspan']}'>{$cell['value']}</td>\n";
                } else {
                    $html .= "<td>{$cell}</td>\n";
                }
            }
            $html .= "</tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        if ($element['type'] === 'dataTable' && $element['props']['pagination']) {
            $html .= "<div class='mui-table-pagination' data-rows-per-page='{$element['props']['rowsPerPage']}'></div>\n";
        }
        return $html;
    }
}