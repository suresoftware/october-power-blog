/**
 * Override the main editor
 */
$(document).on('ajaxSuccess', '#post-form', function (event, context, data) {

    // Hide the old editor
    var tab = $('a[href="#secondarytab-1"]:first');
    tab.parent().remove();

    // Show the power blog editor
    var power = $('a:contains("Power Blog"):first', '#post-form');
    power.click();

    // Move power blog editor to the front of the tag group
    var item = power.closest("li");
    item.parent().prepend(item);

    $("#post-form").show(200);
});

/**
 * Readying the editor
 */

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],      // toggled buttons
    ['blockquote'],

    [{'header': 1}, {'header': 2}],                 // custom button values
    [{'script': 'sub'}, {'script': 'super'}],       // superscript/subscript
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    ['link', 'image', 'video'],                     // add's image support
    ['clean']                                       // formatting remove button
];

$(document).on('ready', function () {
    // Ready the Quill editor
    var quill = new Quill('#quill-editor', {
        modules: {
            toolbar: toolbarOptions
        },
        scrollingContainer: '#quill-container',
        placeholder: 'Write something.',
        theme: 'snow'
    });

    // Load in existing content
    var preloaded = $('#quill-delta').val();
    if (preloaded) {
        preloaded = JSON.parse(preloaded);
        quill.setContents(preloaded, 'api');
    }

    // Store accumulated changes
    var Delta = Quill.import('delta');
    var change = new Delta();
    var autosaveIndicator = $('#quill-autosave-indicator');

    quill.on('text-change', function (delta) {
        autosaveIndicator.text('Unsaved Changes');
        autosaveIndicator.removeClass().addClass('unsaved');
        change = quill.getContents();
        $('#quill-delta').val(JSON.stringify(change));
    });

    // Save periodically
    setInterval(function () {
        if (change.length() > 0) {
            console.log('Saving changes', change);
            autosaveIndicator.text('Saving...');
            autosaveIndicator.removeClass().addClass('saving');

            // Send entire document
            $.post('/suresoftware/powerblog/quill', {
                // Get id from slug
                id: window.location.href.split('/').reverse()[0],
                doc: JSON.stringify(quill.getContents())
            }, function () {
                autosaveIndicator.text('Post Saved');
                autosaveIndicator.removeClass().addClass('saved');
            });
            change = new Delta();
        }
    }, 5 * 1000);

    // Check for unsaved data
    window.onbeforeunload = function () {
        if (change.length() > 0) {
            return 'There are unsaved changes. Are you sure you want to leave?';
        }
    };
});