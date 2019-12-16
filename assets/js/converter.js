/**
 * Quill Importer
 */

var index = 0;
var posts = '';
var quill = '';

// Toggle import button so it can't be clicked a hundred times
function toggleButtonDisabled($button, disabled = null) {
    $button.prop("disabled", function (i, v) {
        if (disabled !== null) return disabled;
        return !v;
    })
}

$(document).ready(function () {
    var $postButton = $('#posts');
    var $importButton = $('#import');
    var $backupButton = $('#backup');

    // Ready the quill editor
    quill = new Quill('#quill-importer', {
        modules: {
            clipboard: true,
        },
        readOnly: true,
    });

    // Custom matcher to interpret <b> tags as bold
    quill.clipboard.addMatcher('B', function (node, delta) {
        return delta.compose(new Delta().retain(delta.length(), {bold: true}));
    });


    $importButton.click(function () {
        index = 0;
        posts = window.posts;
        importPost(index);
        toggleButtonDisabled($importButton, true);
    });


    $backupButton.click(function () {
        window.location = "/backend/rainlab/blog/posts/export";
    });


    $postButton.click(function () {
        window.location = $postButton.data('link');
    });

    if (window.posts.length < 1) {
        toggleButtonDisabled($importButton, true);
        toggleButtonDisabled($postButton, false);
    }
});

// Import posts recursively
function importPost(index) {
    var post = posts[index];

    // Paste HTML contents from post into quill editor
    quill.clipboard.dangerouslyPasteHTML(post.content, 'api'); //seems to return null if dangerous stuff in it

    // Retrieve from the editor as a Delta
    var Delta = quill.getContents();
    index = ++index;

    // Update progress bar
    $('#progress').css("width", (100 / posts.length) * index + '%');

    // API call to store as post->powerblog_delta
    $.post('/suresoftware/powerblog/quill', {
        id: post.id,
        doc: JSON.stringify(Delta),
    }, function () {
        // If index is valid, keep going
        if (index < posts.length) {
            return importPost(index);
        } else {
            $('#import-status').text('Import Successful!');
            toggleButtonDisabled($('#posts'), false); // disable button
            return index;
        }
    });
}