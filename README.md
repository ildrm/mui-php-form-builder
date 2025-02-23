# Material UI Form Builder

This project is a dynamic form builder using PHP and Material UI, enabling the creation of interactive web forms with various elements like text inputs, chip selectors, tables, and more. The goal is to provide a simple and extensible tool for building modern, user-friendly web forms.

## Features
- **Multi-language Support**: Switch between languages (e.g., Persian and English) with text direction (RTL/LTR) support.
- **Diverse Elements**: Includes text fields, multi-selects, chip selectors, tables, sliders, buttons, and more.
- **Responsive Design**: Compatible with various devices (mobile, tablet, desktop).
- **Material UI Styling**: Leverages Material UI's standard styles for a modern look.
- **Interactivity**: Features typing suggestions (Autocomplete) and chip management in selectors.

## Prerequisites
- PHP version 7.4 or higher
- Web server (e.g., Apache or Nginx)
- Modern browser (for proper Material UI rendering)

## Installation
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/material-ui-form-builder.git
   cd material-ui-form-builder
   ```

2. **Set Up Directory Structure**:
    The project should have the following structure:
    ```text
    material-ui-form-builder/
    ├── assets/
    │   ├── css/
    │   │   └── style.css
    │   └── js/
    │       └── script.js
    ├── FormBuilder.php
    ├── index.php
    └── README.md
    ```

3. **Run the Project**:
- Place the project on a local web server (e.g., `XAMPP` or `WAMP`).
- Open index.php in your browser (e.g., `http://localhost/material-ui-form-builder/index.php`).

## Usage
1. **Creating a Form**: In `index.php`, instantiate the `FormBuilder` class and add desired elements:
    ```php
    require_once 'FormBuilder.php';
    
    $form = new FormBuilder('fullForm', 'en');
    $form->configureForm(['action' => 'process.php', 'method' => 'POST', 'columns' => 2]);
    
    $form->addTextField('Name', 'name', 'nameField', ['required' => true]);
    $form->addChipSelect('Languages', 'languages', 'languagesField', ['fa' => 'Persian', 'en' => 'English', 'fr' => 'French']);
    $form->addButton('Submit', 'submit');
    
    echo $form->render();
    ```
2. **Switching Languages**: Change the language via the `lang` URL parameter:
- Persian: `index.php?lang=fa`
- English: `index.php?lang=en`

3. **Customization**:
- Modify styles in `assets/css/style.css`.
- Adjust element behavior in `assets/js/script.js`.

## Project Structure
- `FormBuilder.php`: Core class for building and rendering forms.
- `index.php`: Main file displaying a sample form.
- `assets/css/style.css`: Custom styles for form elements.
- `assets/js/script.js`: JavaScript for element interactivity (e.g., chips, suggestions).

## Example Output
Running the above code generates a form with a text field, a chip selector (for languages), and a submit button. In the chip selector:
- Typing "Per" suggests "Persian".
- Selecting it adds a chip (e.g., "Persian ×") inside the text box.
- Clicking "×" removes the chip.

## Development
To add a new element:
1. Add a method to `FormBuilder.php` (e.g., `addNewElement`).
2. Implement its rendering in `renderElement`.
3. Style it in `style.css` and define its behavior in `script.js`.

## Limitations
- Currently uses Material UI via CDN. For better performance, consider hosting files locally.
- Autocomplete suggestions are logged to the console and require UI rendering.

## Contributing
If you have ideas or suggestions, feel free to submit a Pull Request or open an Issue.