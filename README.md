Power Blog an OctoberCMS Plugin
=============


__*for more fields, please open an issue and request this on the git repository__

### Features
* Author Component

### Future Development
* Custom Blog Editor
* Comments

### Like this Plugin?
If you like this plugin, plese give it a star on GitHub.

## Installation
To install this plugin you have to click on __add to project__ or need to type __SureSoftware.PowerBlog__ in Backend *System > updates > install plugin*

The plugin currently includes one component:
* Author

Current fields:
* Author Name
* Author Bio
* Author Avatar

## Using the Author Component
Navigate to *Power Blog* from the main navigation menu.

Create New Author, save.

In the Blog editor, select the Power Blog tab to assign an author to the post.

Insert component onto page:

``````````````````
{% component 'Author' data=blogPost.post %}
``````````````````