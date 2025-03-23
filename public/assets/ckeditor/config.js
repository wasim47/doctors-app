/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	 config.allowedContent = true;
	 config.extraAllowedContent = 'div(*)';
	 config.extraAllowedContent = 'div(col-md-*,container,container-fluid,row,about-container)';
	 config.extraAllowedContent = 'div(col-sm-*,container,container-fluid,row,about-container)';
	 config.extraAllowedContent = 'div(col-lg-*,container,container-fluid,row,about-container)';
	 config.extraAllowedContent = 'div(col-xs-*,container,container-fluid,row,about-container)';
	 
	//config.extraPlugins = 'uploadimage,uploadwidget,widget,clipboard,lineutils,dialog,dialogui,notificationaggregator,notification,toolbar,button,filetools';
	   config.filebrowserBrowseUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
	   config.filebrowserImageBrowseUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
	   config.filebrowserFlashBrowseUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
	   config.filebrowserUploadUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
	   config.filebrowserImageUploadUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
	   config.filebrowserFlashUploadUrl = 'http://softxmagic.com/pioneer/assets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
	   CKEDITOR.dtd.$removeEmpty['i'] = false;
	   CKEDITOR.dtd.$removeEmpty['span'] = false;
};
