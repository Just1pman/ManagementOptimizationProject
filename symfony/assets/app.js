/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
// alert( 'Привет, мир!' );
const $ = require('jquery');



Action($('#education_list'), $('<a href="#" class="btn btn-info my-3 ms-3">Add new education</a>'));
Action($('#language_list'), $('<a href="#" class="btn btn-info my-3 ms-3">Add new language</a>'));
Action($('#summary_list'), $('<a href="#" class="btn btn-info my-3 ms-3">Add new summary</a>'));
Action($('#experience_list'), $('<a href="#" class="btn btn-info my-3 ms-3">Add new experience</a>'));


function Action($holder, $button) {
    $(document).ready(function () {
        // $holder = $('#exp_list');
        $holder.append($button);
        $holder.data('index', $holder.find('.panel').length)
        $holder.find('.panel').each(function () {
            addRemoveButton($(this));
        });
        $button.click(function (e) {
            e.preventDefault();
            addNewForm($holder, $button);
        })
    });
}

function addNewForm($Holder, $button) {
    const prototype = $Holder.data('prototype');
    let index = $Holder.data('index');
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $Holder.data('index', index++);
    const $panel = $('<div class="panel panel-form"><div class="panel-heading"></div></div>');
    const $panelBody = $('<div class="panel-body row mb-3"></div>').append(newForm);
    $panel.append($panelBody);
    addRemoveButton($panel);
    $button.before($panel);
}

function addRemoveButton ($panel) {
    // create remove button
    const $removeButton = $('<a href="#" class="btn btn-danger">Remove</a>');
    // appending the remove button to the panel footer
    const $panelFooter = $('<div class="panel-footer mb-2"></div>').append($removeButton);
    // handle the click event of the remove button
    $removeButton.click(function (e) {
        e.preventDefault();
        // gets the parent of the button that we clicked on "the panel" and animates it
        // after the animation is done the element (the panel) is removed from the html
        $(e.target).parents('.panel').slideUp(1000, function () {
            $(this).remove();
        })
    });
    $panel.append($panelFooter);
}

// const imagesContext = require.context('./images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
// imagesContext.keys().forEach(imagesContext);

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');