
/**
 * Quill Importer
 */

let index = 0;
let posts = '';
let quill = '';

// Toggle import button so it can't be clicked a hundred times
function toggleImportButton() {
    $('#import').prop("disabled", function(i, v) {
        return !v;
    })
}


 $(window).ready( function() {

     // Ready the quill editor
      quill = new Quill('#quill-importer', {
         modules: {
             clipboard: true,
         },
         readOnly: true,
     });

     // Custom matcher to interpret <b> tags as bold
     quill.clipboard.addMatcher('B', function(node, delta) {
         return delta.compose(new Delta().retain(delta.length(), { bold: true }));
     });

     // Send initial post
      $('#import').click( function() {
          index = 0; // do I need this? at click should it always start from 0?
          posts = window.posts;
          importPost(index);
          toggleImportButton(); // disable button
     });
 });

 // Import posts recursively
 function importPost(index) {
     let post = posts[index];

     // Paste HTML contents from post into quill editor
     quill.clipboard.dangerouslyPasteHTML(post.content, 'api'); //seems to return null if dangerous stuff in it

     // Retrieve from the editor as a Delta
     let Delta = quill.getContents();

     // Increment index
     index = ++index;

     // Update progress bar
     $('#progress').css("width", (100/posts.length) * index + '%');

     // API call to store as post->powerblog_delta
     $.post('/suresoftware/powerblog/quill', {
         id: post.id,
         doc: JSON.stringify(Delta),
     }, function () {
         // If index is valid, keep going
         if(index < posts.length) {
             return importPost(index);
         } else {
             $('#import-status').text('Import Successful!');
             return index;
         }
     });
 }