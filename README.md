# Bookreader Plugin for Resourcespace

Create a Resource Space plugin so that Internet Archive's BookReader works off the shelf. IA BookReader is an online book viewer with many unique features such as a full text search. The plugin makes reading books on ResourceSpace a more pleasant experience. For more information on BookReader you can view the README in BookReader-source or visit their website. 

The Internet Archive Bookreader: https://openlibrary.org/dev/docs/bookreader.

For info on writing plugins for ResourceSpace, check out it's [knowledge base](https://www.resourcespace.com/knowledge-base/systemadmin/modifications-and-writing-your-own-plugin).

## Status: In Testing
* Users are able to view pdf's using the BookReader plugin
* Users are able to run text-based searching
* All ui's are working except the Share feature which is to be removed
* About section missing a couple details


## Getting Started
Get a copy of the repo because you will need edit a couple of files. In the files /include/bookreader_init.php and exec_testApi.php you have to set your private API key ($private_key). You can find this key by logging into your resourcespace instance and going to the user account page. Enter your details for the following...
```
$private_key = "your_private_api_key"
$user        = "username"
$url         = "../link/to/resourcespace/"
```
Make sure to save and depending on how you plan to enable the plugin, you may or may not need to package your plugin. More in the next Section.


### Enabling the plugin
There are two ways to add the plugins to resourcespace outlined in the knowledge base under [Managing Plugins](https://www.resourcespace.com/knowledge-base/systemadmin/managing_plugins).

If you plan to manually configurate the files then I will outline some steps.
* Grab the entire bookreader folder and place it into your .../resourcespace/plugins/ folder
* Enable the plugin by modifying $plugins in include/config.php 
```
I added the line: array_push($plugins, 'bookreader')
```
If you plan to use the plugin manager, then you will need to package the plugin. You can do so by doing tar and gzip on your plugin (bookreader.tar.gz) and then renaming it to bookreader.rsp. This creates a ResourceSpace plugin file that you can upload. Now you can follow the steps in the link [Managing Plugins](https://www.resourcespace.com/knowledge-base/systemadmin/managing_plugins).
