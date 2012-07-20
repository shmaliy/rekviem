<script type="text/javascript" src="{#basedir#}/swf/swfupload/swfupload.js"></script>
<script type="text/javascript" src="{#basedir#}/swf/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="{#basedir#}/swf/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="{#basedir#}/swf/swfupload/handlers.js"></script>
<script type="text/javascript">
var swfu;
function swfup(){
	var settings = {
		// Flash Settings		
		flash_url : "{#basedir#}/swf/swfupload/swfupload.swf",
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		//prevent_swf_caching : false,
		// Backend settings
		upload_url: "{#basedir#}/upload.php?path={#path#}",
		file_post_name: "userfile",

		// Flash file settings
		file_size_limit : "200 MB",
		file_types : "*.*",			// or you could use something like: "*.doc;*.wpd;*.pdf",
		file_types_description : "All Files",
		file_upload_limit : 5,
		file_queue_limit : 5,

		// Event handler settings
		//swfupload_loaded_handler : swfUploadLoaded,
		file_dialog_start_handler: fileDialogStart,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete,	// Queue plugin event

		// Button Settings
		button_image_url : "{#basedir#}/swf/swfupload/XPButtonUploadText_70x22.png",
		button_placeholder_id : "spanButtonPlaceHolder",
		button_width: 70,
		button_height: 22,
		
		// Debug settings
		debug: false
	};
	swfu = new SWFUpload(settings);
}
</script>
<div class="tabs_btn" id="upload_btn">
	<a href="javascript:tabs('upload', 0)" class="selected"><span>Браузер</span></a>
	<a href="javascript:tabs('upload', 1)"><span>Загрузить</span></a>
	<div class="clr"></div>
</div>
<div id="upload">
	<div class="tab" style="display:block;">
		{#fb#}
	</div>
	<div class="tab">
		<div class="folders"><div class="txt">Папка:</div><select id="fb_path2" onchange="call('core_fb','_fb_setpath',this.value);">{#folders#}</select><div class="f_mode"><a class="uppath" id="fb_uppath2" href="javascript:call('core_fb','_fb_setpath','{#uppath#}');"><img class="f_up" src="{#basedir#}/images/folder_up3.png" /></a><a class="refresh" id="fb_refresh2" href="javascript:call('core','_fb_setpath','{#currpath#}');"><img class="f_up" src="{#basedir#}/images/refresh.png" /></a></div></div>
		<form id="form1" enctype="multipart/form-data" action="{#basedir#}/upload.php?path={#path#}" method="post">
			<div class="fieldset flash" id="fsUploadProgress">
				<span class="legend">Очередь загрузки</span>
			</div>
			<div class="divButtons">
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="Отменить все" onclick="swfu.cancelQueue();" disabled="disabled" style="margin:0;" />
			</div>
			<div id="divStatus">0 файлов загружено</div>
			<div class="clr"></div>
		</form>
	</div>
</div>