
/**
 * Quill Importer
 */

// import markdown post->content,
// convert to html,
// import to quill to convert to delta,
// store in database as json
//
 $(window).ready( function() {
     // console.log('hello');

     //ready the quill editor
     var quill = new Quill('#quill-importer', {

     });

     //var Delta = Quill.import('post.content');
     console.log(window.posts);

      //button click
      $('#import').click( function() {
          console.log('click!');
     //     var postContents = $('content');
     //     for(var ) {
     //
     //     }
     })
 });


