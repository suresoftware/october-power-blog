Power Blog an OctoberCMS Plugin
=============

__For bugs and feature request, please open an issue on the Git Repository__


### Features
* Advanced Quill Editor
* Detailed Author Component

### Like this Plugin?
If you like this plugin, plese give it a star on GitHub.

## Installation
1. To install this plugin you have to click on __add to project__ or need to type __SureSoftware.PowerBlog__ in Backend 
*System > updates > install plugin*

2. Once you have installed the plugin, you will need to navigate to your backend > PowerBlog > Convert and convert your 
blog posts into Power Blogs. 

3. Finally, update the component you are using to display your blog posts to the Power Blog Post component.

The plugin includes two components:
* Power Blog Post
* Author Display

Author Fields:
* Author Name
* Author Bio
* Author Avatar

## Using the PowerBlog Post Component

Insert component onto page and add the following code:

``````````````````
{% component 'Post' %}
``````````````````

## Using the Author Component
Navigate to *Power Blog* from the main navigation menu.

Create New Author, save.

In the Blog editor, select the Power Blog tab to assign an author to the post.

Insert component onto page, this must be used with the PowerBlog Posts component:

``````````````````
{% component 'Author' data=Post.post %}
``````````````````



### Future Development
* Comments
* Revision History
* Additional Author Fields
* Integration with Power SEO