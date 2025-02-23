<!DOCTYPE html>
<html lang="<?php echo $locale ?? 'fa'; ?>" dir="<?php echo $direction ?? 'rtl'; ?>">
<head>
    <meta charset="UTF-8">
    <title>Form Builder با Material UI</title>
    <link rel="stylesheet" href="https://unpkg.com/@mui/material@latest/dist/css/mui.min.css">
    <script src="https://unpkg.com/@mui/material@latest/dist/mui.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>
<?php
require_once 'FormBuilder.php';

$locale = isset($_GET['lang']) ? $_GET['lang'] : 'fa';
$form = new FormBuilder('fullForm', $locale);

$form->configureForm([
    'action' => 'process.php',
    'method' => 'POST',
    'columns' => 2
]);

$labels = $locale === 'fa' ? [
    'text' => 'نام',
    'select' => 'نوع درخواست',
    'checkbox' => 'موافقت با شرایط',
    'radio' => 'جنسیت',
    'switch' => 'اعلان‌ها',
    'slider' => 'سن',
    'date' => 'تاریخ تولد',
    'auto' => 'شهر',
    'checkmarks' => 'مهارت‌ها',
    'chip' => 'زبان‌ها',
    'button' => 'ارسال',
    'accordion' => 'جزئیات بیشتر',
    'alert' => 'هشدار',
    'card' => 'کارت نمونه',
    'dialog' => 'گفتگو',
    'snackbar' => 'پیام نمونه',
] : [
    'text' => 'Name',
    'select' => 'Request Type',
    'checkbox' => ' Agree to Terms',
    'radio' => 'Gender',
    'switch' => 'Notifications',
    'slider' => 'Age',
    'date' => 'Birthdate',
    'auto' => 'City',
    'checkmarks' => 'Skills',
    'chip' => 'Languages',
    'button' => 'Submit',
    'accordion' => 'More Details',
    'alert' => 'Warning',
    'card' => 'Sample Card',
    'dialog' => 'Dialog',
    'snackbar' => 'Sample message',
];

$options = $locale === 'fa' ? [
    'select' => ['support' => 'پشتیبانی', 'sales' => 'فروش'],
    'radio' => ['male' => 'مرد', 'female' => 'زن'],
    'checkmarks' => ['php' => 'PHP', 'js' => 'جاوااسکریپت', 'css' => 'CSS'],
    'chip' => ['fa' => 'فارسی', 'en' => 'انگلیسی', 'fr' => 'فرانسوی'],
    'auto' => ['تهران', 'اصفهان', 'شیراز'],
] : [
    'select' => ['support' => 'Support', 'sales' => 'Sales'],
    'radio' => ['male' => 'Male', 'female' => 'Female'],
    'checkmarks' => ['php' => 'PHP', 'js' => 'JavaScript', 'css' => 'CSS'],
    'chip' => ['fa' => 'Persian', 'en' => 'English', 'fr' => 'French'],
    'auto' => ['Tehran', 'Isfahan', 'Shiraz'],
];

$form->addTextField($labels['text'], 'name', 'nameField', ['placeholder' => $locale === 'fa' ? 'نام خود را وارد کنید' : 'Enter your name', 'required' => true]);
$form->addSelect($labels['select'], 'requestType', 'requestTypeField', $options['select'], ['required' => true]);
$form->addCheckbox($labels['checkbox'], 'terms', 'termsField');
$form->addRadioGroup($labels['radio'], 'gender', 'genderField', $options['radio'], ['defaultValue' => 'male', 'row' => true]);
$form->addSwitch($labels['switch'], 'notifications', 'notificationsField');
$form->addSlider($labels['slider'], 'age', 'ageField', ['min' => 0, 'max' => 100, 'defaultValue' => 25]);
$form->addDatePicker($labels['date'], 'birthdate', 'birthdateField', ['required' => true]);
$form->addAutocomplete($labels['auto'], 'city', 'cityField', $options['auto']);
$form->addCheckmarksSelect($labels['checkmarks'], 'skills', 'skillsField', $options['checkmarks']);
$form->addChipSelect($labels['chip'], 'languages', 'languagesField', $options['chip']);
$form->addNestedList('list1', [
    ['label' => $locale === 'fa' ? 'دسته 1' : 'Category 1', 'children' => [$locale === 'fa' ? 'آیتم 1-1' : 'Item 1-1', $locale === 'fa' ? 'آیتم 1-2' : 'Item 1-2']],
    ['label' => $locale === 'fa' ? 'دسته 2' : 'Category 2', 'children' => [$locale === 'fa' ? 'آیتم 2-1' : 'Item 2-1']]
]);
$form->addBasicTable('table1', [$labels['text'], $labels['slider']], $locale === 'fa' ? [['علی', 25], ['سارا', 30]] : [['Ali', 25], ['Sara', 30]]);
$form->addDataTable('table2', [$labels['text'], $labels['slider']], $locale === 'fa' ? [['علی', 25], ['سارا', 30], ['محمد', 28]] : [['Ali', 25], ['Sara', 30], ['Mohammad', 28]], ['pagination' => true]);
$form->addDenseTable('table3', [$labels['text'], $labels['slider']], $locale === 'fa' ? [['علی', 25], ['سارا', 30]] : [['Ali', 25], ['Sara', 30]]);
$form->addSortingSelectingTable('table4', [$labels['text'], $labels['slider']], $locale === 'fa' ? [['علی', 25], ['سارا', 30]] : [['Ali', 25], ['Sara', 30]]);
$form->addSpanningTable('table5', [$labels['text'], $labels['slider']], $locale === 'fa' ? [['علی', 25], [['colspan' => 2, 'value' => 'سارا - 30']]] : [['Ali', 25], [['colspan' => 2, 'value' => 'Sara - 30']]]);
$form->addVirtualizedTable('table6', [$labels['text'], $labels['slider']], array_fill(0, 100, [$locale === 'fa' ? 'کاربر' : 'User', rand(20, 50)]));
$form->addButton($labels['button'], 'submit', ['fullWidth' => true]);
$form->addAccordion($labels['accordion'], 'accordion1', '<p>' . ($locale === 'fa' ? 'محتوای نمونه' : 'Sample content') . '</p>');
$form->addAlert($labels['alert'], 'alert1', $locale === 'fa' ? 'این یک پیام است' : 'This is a message', ['severity' => 'warning', 'closable' => true]);
$form->addCard('card1', '<h3>' . $labels['card'] . '</h3><p>' . ($locale === 'fa' ? 'محتوا' : 'Content') . '</p>');
$form->addTabs('tabs1', [
    ['label' => $locale === 'fa' ? 'تب 1' : 'Tab 1', 'content' => $locale === 'fa' ? 'محتوای تب 1' : 'Tab 1 Content'],
    ['label' => $locale === 'fa' ? 'تب 2' : 'Tab 2', 'content' => $locale === 'fa' ? 'محتوای تب 2' : 'Tab 2 Content']
]);
$form->addDialog($labels['dialog'], 'dialog1', '<p>' . ($locale === 'fa' ? 'محتوای گفتگو' : 'Dialog content') . '</p>', ['open' => true]);
$form->addSnackbar('snackbar1', $labels['snackbar'], ['open' => true]);

echo $form->render();
?>

<p>
    <a href="?lang=fa">فارسی</a> | 
    <a href="?lang=en">English</a>
</p>
</body>
</html>