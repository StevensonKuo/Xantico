<?php
namespace app\admin\model\bootstrap\hplus;

use think\Exception;

class FileUploader extends \app\admin\model\bootstrap\basic\FileUploader
{

    protected $type; // string [vertical|horizontal]
    protected $preview; // string
    
    private $isMultiple = false; // boolean
    private $isRequired = false; // boolean
    private $validation = array (); // array
    
    /*
     * 
<script src="/static/admin/js/aliyun-sdk.min.js"></script>
<script src="/static/admin/js/vod-sdk-upload-1.1.0.min.js"></script>
     */
    
    /**
     * @desc generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class = $this->customClass;
        $type = in_array($this->type, array("vertical", "horizontal")) ? $this->type : "";
//         $class [] = "form-control"; 
        
        switch ($this->type) {
            default:
            case "image":
                if ($this->id) {
                    $html = "<div id=\"{$this->id}-uploader-image\"" . (!empty($class) ? " class=\"" . join($class, " ") . "\"" : "") .">
						      <!-- keeps items -->
        						<div id=\"{$this->id}-fileList\" class=\"uploader-list\">\n";
                    if ($this->preview) {
                        $prev = explode(",", $this->preview);
                        if (!isset ($prev [1]) || !isset($prev [2])) {
                            if (strtolower(substr($this->preview, 0, 5)) == "data:" && function_exists("getimagesizefromstring")) {
                                $fileSize = @getimagesizefromstring($this->preview);
                            } else {
                                $fileSize = @getimagesize($this->preview);
                            }
                            
                            $prev = array (0 => $this->preview, 1 => (isset($fileSize[0]) ? $fileSize[0] : 100), 2 => (isset($fileSize[1]) ? $fileSize[1] : 100));
                        }
                        $html .= "<div class=\"file-item thumbnail\" style=\"width: {$prev [1]}px; height: {$prev [2]}px\">".
                                "<img src=\"{$prev[0]}\"/>" . 
                                "<div class=\"info\">{$prev [1]} x {$prev [2]}</div>".
                                "</div>";
                    }
        			$html .= "</div>\n";
        			if (!$this->isDisabled && !$this->isStatic) {
                        $html .= "\t<div id=\"{$this->id}-filePicker\"><i class=\"layui-icon\">&#xe67c;</i>&nbsp;" . ($this->text ? $this->text : "Upload") . "</div>\n";
        			}
				    $html .= "</div>\n";
                    if (!$this->isDisabled) {
                        $html .= "<input id=\"{$this->id}\" style=\"width: 0px; position: absolute; top-margin: -80px; z-index: -999;\" name=\"{$this->name}\"" . ($this->preview ? " value=\"{$this->preview}\"" : "") . ">\n";
				    }
                } else {
                    // There must be a ID for file uploader scripts to run.
                    throw new Exception("There must be a ID for file uploader scripts to run.");
                }
                
                if ($this->help) {
                    $html .= "<span class=\"help-block m-b-none\">{$this->help}</span>\n";
                }
                
                $jQuery = "
                    $(document).ready(function() {
                    		\$list = \$('#{$this->id}-fileList'),
                    		ratio = window.devicePixelRatio || 1,
                    		thumbnailWidth = 100 * ratio,
                    		thumbnailHeight = 100 * ratio,
                    		uploader;
                    		// 初始化Web Uploader
                    		var uploader = WebUploader.create({
                    			// 选完文件后，是否自动上传。
                    			auto: true,
                    			// swf文件路径
                    			swf: '__PLUGINS__/webupload/swf/Uploader.swf',
                    			// 文件接收服务端。
                    			server: '/admin/ajax/image_upload',
                    			// 选择文件的按钮。可选。
                    			// 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    			pick: '#{$this->id}-filePicker',
                    			// 只允许选择图片文件。
                    			accept: {
                    				title: 'Images',
                    				extensions: 'gif,jpg,jpeg,bmp,png',
                    				mimeTypes: 'image/*'
                    			}
                    		});
                    
                    		// 当有文件添加进来的时候
                    		uploader.on( 'fileQueued', function( file ) {
                    			var \$li = \$(
                    					'<div id=\"' + file.id + '\" class=\"file-item thumbnail\">' +
                    						'<img>' +
                    						'<div class=\"info\">' + file.name + '</div>' +
                    					'</div>'
                    					),
                    				\$img = \$li.find('img');
                    			// \$list为容器jQuery实例
                    			\$list." . ($this->isMultiple ? "append" : "html") . "( \$li );
                    			// 创建缩略图
                    			// 如果为非图片文件，可以不用调用此方法。
                    			// thumbnailWidth x thumbnailHeight 为 100 x 100
                    			uploader.makeThumb( file, function( error, src ) {
                    				if ( error ) {
                    					\$img.replaceWith('<span>不能预览</span>');
                    					return;
                    				}
                    				\$img.attr( 'src', src );
                    			}, thumbnailWidth, thumbnailHeight );
                    		});
                    
                    		// 文件上传过程中创建进度条实时显示。
                    		uploader.on( 'uploadProgress', function( file, percentage ) {
                    			var \$li = $( '#'+file.id ),
                    				\$percent = \$li.find('.progress span');
                    			// 避免重复创建
                    			if ( !\$percent.length ) {
                    				\$percent = $('<p class=\"progress\"><span></span></p>')
                    						.appendTo( \$li )
                    						.find('span');
                    			}
                    			\$percent.css( 'width', percentage * 100 + '%' );
                    		});
                    		var arr = new Array();
                    		// 文件上传成功，给item添加成功class, 用样式标记上传成功。
                    		uploader.on( 'uploadSuccess', function( file,response ) {
                    			\$( '#'+file.id ).addClass('upload-state-done');
                    			//上传完毕
                    			var data = response.data;
                    			var img = response.data.url+\",\"+response.data.width+\",\"+response.data.height+\",\"+response.data.size;
                    			arr.push(img);
                    			images = arr.join('&');
                    			\$('#{$this->id}').val(". ($this->isMultiple ? "images" : "img") . ");
                    			console.log(images);
                    		});
                    
                    		// 文件上传失败，显示上传出错。
                    		uploader.on( 'uploadError', function( file ) {
                    			var \$li = $( '#'+file.id ),
                    				\$error = \$li.find('div.error');
                    			// 避免重复创建
                    			if ( !\$error.length ) {
                    				\$error = $('<div class=\"error\"></div>').appendTo( \$li );
                    			}
                    			\$error.text('上传失败');
                    		});
                    
                    		// 完成上传完了，成功或者失败，先删除进度条。
                    		uploader.on( 'uploadComplete', function( file ) {
                    			$( '#'+file.id ).find('.progress').remove();
                    		})        
                    });\n";
                if ($this->isDisabled || $this->isStatic) $jQuery = "";
                break;
            case "video":
                if ($this->isStatic) {
                    $_video = new Video("plyr");
                    $_video->setSource($this->preview)
                        ->setWithControls()
                        ->setPoster($this->attrs['poster']);
                    $html = $_video->render();
                } else {
                    $html = "
            			<input type=\"hidden\" id=\"{$this->id}UploadAuth\" />
        				<input type=\"hidden\" id=\"{$this->id}UploadAddress\" />
    	   		      	<input type=\"hidden\" id=\"{$this->id}VideoId\" name=\"{$this->name}_id\" />
    		  		    <input type=\"hidden\" id=\"{$this->id}VideoUrl\" name=\"{$this->name}_url\" />
    					<div class=\"layui-tab layui-tab-brief\" lay-filter=\"docDemoTabBrief\">
    						<ul class=\"layui-tab-title\">
    							<li class=\"layui-this\">视频URL地址</li>
    							<li>上传视频</li>
    						</ul>
    						<div class=\"layui-tab-content\" style=\"height: 100px;\">
    							<div class=\"layui-tab-item layui-show\">
    								<div class=\"layui-inline\">
    									<input type=\"text\" id=\"{$this->id}UrlStr\" name=\"url_str\" class=\"layui-input\" style=\"width: 500px;\">
    								</div>
    								<div class=\"layui-inline\">
    									<div class=\"layui-input-inline\" style=\"padding: 9px 15px;\">
    										<select name=\"video_source\" id=\"video_source\">
    											<option value=\"0\">其他</option>
    											<option value=\"1\">每日开眼</option>
    										</select>
    									</div>
    								</div>
    								<div class=\"layui-inline\">
    									<a class=\"layui-btn\" style=\"text-decoration-line: none;\" onclick=\"videoPreview()\" data-toggle=\"modal\" data-target=\"#{$this->id}-preview\">解析并预览</a>
    								</div>
    							</div>
    							<div class=\"layui-tab-item\">
                                    <div class=\"layui-inline\">
    								    <input type=\"file\" name=\"{$this->name}\" id=\"{$this->id}\"/>
                                    </div>
    								<div class=\"layui-inline layui-progress\" lay-filter=\"uploadProgress\" lay-showPercent=\"true\" style=\"width: 200px;margin-top: 30px\">
    									<div class=\"layui-progress-bar layui-bg-blue\" lay-percent=\"0%\"></div>
    								</div>
                                    <div class=\"layui-inline\">
    								    <a class=\"layui-btn\" id=\"upload-start\" onclick=\"start()\"><i class=\"layui-icon\">&#xe67c;</i>&nbsp;上傳視頻</a>
                                    </div>
    								<div class=\"layui-inline\">
    									<a id=\"upload-preview\" class=\"layui-btn layui-btn-disabled\" style=\"text-decoration-line: none;\" onclick=\"videoPreview()\" data-toggle=\"modal\" data-target=\"#{$this->id}-preview\">预览</a>
    								</div>
    							</div>
    						</div>
    					</div>
                        <!-- video preview modal -->
                        <div class=\"modal fade\" id=\"{$this->id}-preview\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
                        	<div class=\"modal-dialog\" role=\"document\">
                        		<div class=\"modal-content\">
                        			<div class=\"modal-header\">
                        				<h4 class=\"modal-title\" id=\"myModalLabel\">视频预览</h4>
                        			</div>
                        			<div class=\"modal-body\" style=\"padding-bottom: 20px;\">
                        				<video autoplay muted loop src=\"\" id=\"video-box\" width=\"100%\"></video>
                        			</div>
                        			<div class=\"modal-footer\">
                        				<button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\">关闭</button>
                        			</div>
                        		</div>
                        	</div>
                        </div>
                    ";
    
                    $jQuery = "
                        var uploader;
                    	window.onload = function() {
                    		uploader = new VODUpload({
                    			// 开始上传
                    			'onUploadstarted': function (uploadInfo) {
                    				var uploadAuth = \$(\"#{$this->id}UploadAuth\").val();
                    				var uploadAddress = \$(\"#{$this->id}UploadAddress\").val();
                    				// 设置上传凭证
                    				uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress);
                    			},
                    			// 文件上传成功
                    			'onUploadSucceed': function (uploadInfo) {
                    				// 改变上传按钮
                    				\$(\"#upload-start\").html('上传完成');
                    				\$(\"#upload-start\").addClass('layui-btn-disabled');
                                    var vid = \$('#{$this->id}VideoId').val();
                                    var url = '/api/Campaign/getVideoUrl/video_id/' + vid;
                                    \$.post(url, null, function (res) {
                                        if (res.length > 0) {
                                            \$('#{$this->id}UrlStr').val(res);
                                            \$(\"#upload-preview\").removeClass('layui-btn-disabled');
                                        }
                                    });
                    			},
                    			
                    			'onUploadFailed': function (uploadInfo, code, message) {
                                    // @todo 文件上传失败                 
                    			},
                    			// 文件上传进度，单位：字节
                    			'onUploadProgress': function (uploadInfo, totalSize, uploadedSize) {
                    				var progress = Math.ceil(uploadedSize * 100 / totalSize) + \"%\";
                    				// 视频上传进度条样式
                    				layui.use('element', function(){
                    					var element = layui.element;
                    					element.progress('uploadProgress', progress);
                    				});
                    				// 改变上传按钮
                    				\$(\"#upload-start\").html('上传中......');
                    			},
                    
                    			// 上传凭证超时
                    			'onUploadTokenExpired': function () {
                    				console.log(\"onUploadTokenExpired\");
                    				uploader.resumeUploadWithAuth(uploadAuth);
                    			}
                    		});
                    
                    	};
                    
                    	\$(\"#{$this->id}\").on('change', function (event) {
                			// 获取文件名
                			var userData = '{\"Vod\":{\"UserData\":\"{\"IsShowWaterMark\":false,\"Priority\":7}\"}}';
                            var vfiles = event.target.files; 
                			for(var i=0; i < vfiles.length; i++) {
                				// 点播上传。每次上传都是独立的OSS object，所以添加文件时，不需要设置OSS的属性
                				uploader.addFile(vfiles[i], null, null, null, userData);
                			}
                		});
                    
                    	function start() {
                    		var url = '/admin/ajax/video_auth.html';
                    		var file = \$(\"#{$this->id}\").val();
                    		var name = file.substr(file.lastIndexOf('\\\\')+1);
                    
                    		\$.post(url,{title:name,name:name},function(data){
                    			\$(\"#{$this->id}UploadAuth\").val(data.uploadAuth);
                    			\$(\"#{$this->id}UploadAddress\").val(data.uploadAddress);
                    			\$(\"#{$this->id}VideoId\").val(data.videoId);
                    
                    			// 开始上传视频
                    			uploader.startUpload();
                    		})
                    	}
    
                        function videoPreview(){
                    		var videoSource = \$(\"#video_source\").val();
                    		var url = '/admin/ajax/video_analysis.html';
                    		var url_str = \$('#{$this->id}UrlStr').val();
                    		\$.post(url, { url_str: url_str, source: videoSource }, function(res) {
                    			if( res.code == 0 ){
                    				var video_url = res.data.url;
                    				\$(\"#{$this->id}VideoUrl\").val(video_url);
                    				\$(\"#video-box\").attr('src', video_url);
                    			}
                    		})
                    	}
                    ";
                                    
                }
        }
        
        switch ($this->formType) {
            default:
            case "horizontal":
                if ($this->caption) {
                    $labelHtml = "<label class=\"col-sm-{$this->labelRatio [0]} control-label no-padding-right\" for=\"{$this->id}\">";
                    if ($this->isRequired) {
                        $_icon = new Icon("asterisk", array ("colorSet" => "danger"));
                        $labelHtml .= $_icon->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                } else {
                    $labelHtml = "";
                    $this->labelRatio [1] = $this->labelRatio [1] + $this->labelRatio [0];
                }
                
                $html = "<div class=\"form-group\">\n".
                        $labelHtml . "\n" .
                        "<div class=\"col-sm-{$this->labelRatio [1]}\">" . $html . "</div></div>";
                break;
            case "inline":
                if ($this->caption) {
                    $labelHtml .= "<label class=\"sr-only\" for=\"{$this->id}\">";
                    if ($this->isRequired) {
                        $_icon = new Icon("asterisk", array ("colorSet" => "danger"));
                        $labelHtml .= $_icon->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                }
                $html = "<div class=\"form-group\">\n".
                        $labelHtml . "\n" .
                        $html . "</div>";
                break;
        }
        
        $this->html = $html;
        $this->jQuery = $jQuery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    /**
     * @return the $isMultiple
     */
    public function getIsMultiple()
    {
        return $this->isMultiple;
    }

    /**
     * @desc 是否支援多個檔案上傳
     * @param field_type $isMultiple
     */
    public function setIsMultiple($isMultiple = true)
    {
        $this->isMultiple = $isMultiple;
        return $this;
    }
    
    /**
     *
     * @param string $message
     */
    public function setRequired ($message = "", $isRequired = true) {
        $this->isRequired = $isRequired;
        $this->validation ['required'] = $isRequired;
        $this->validation ['requiredMessage'] = $message ? $message : "請填寫 " . $this->caption;
        
        return $this;
    }
    
    /**
     * @return the $isRequired
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }
    
    /**
     * @return the $validation
     */
    public function getValidation()
    {
        return $this->validation;
    }
    /**
     * @return the $preview
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param field_type $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
        return $this;
    }

    
   
}