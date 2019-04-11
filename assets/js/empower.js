/**
 * Override the main editor
 */
$(document).on('ajaxSuccess', '#post-form', function(event, context, data) {

    //hide the old editor
    var tab = $('a[href="#secondarytab-1"]:first');
    tab.parent().remove();

    //show the power blog editor
    var power = $('a[title="Power Blog"]:first');
    power.click();

    //move power blog editor to the front of the tag group
    var item = power.closest("li");
    item.parent().prepend(item);

    $("#post-form").show(200);

});

/**
 * Readying the editor
 */

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],

    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [ 'link', 'image', 'video', 'formula' ],          // add's image support
    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': [] }],
    [{ 'align': [] }],

    ['clean']                                         // remove formatting button
];

$(document).on('ready', function() {
    var quill = new Quill('#quill-editor', {
        modules: {
            toolbar: toolbarOptions
        },
        scrollingContainer: '#scrolling-container',
        placeholder: 'Write something.',
        theme: 'snow'
    });

    // Store accumulated changes
    var Delta = Quill.import('delta');
    var change = new Delta();
    quill.on('text-change', function(delta) {
        change = change.compose(delta);
        $('#quill-delta').val(JSON.stringify(change));
    });

    // Save periodically
    setInterval(function () {
        if (change.length() > 0) {
            console.log('Saving changes', change);

            // Send entire document
            $.post('/suresoftware/powerblog/quill', {
                // Get id from slug
                id: window.location.href.split('/').reverse()[0],
                doc: JSON.stringify(quill.getContents())
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