<?php 

//print_r($_FILES["file"]); die;

if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
	$upfile=$_FILES["file"]; 
	//获取数组里面的值 
	$name = $upfile["name"];//上传文件的文件名 
	$type = $upfile["type"];//上传文件的类型 
	$size = $upfile["size"];//上传文件的大小 
	$tmp_name = $upfile["tmp_name"];//上传文件的临时存放路径 
	//判断是否为图片 
	switch ($type){ 
		case 'image/pjpeg':
			$okType = true;
			break; 
		case 'image/jpeg' : 
			$okType = true; 
			break; 
		case 'image/gif':
			$okType=true; 
			break; 
		case 'image/png':
			$okType=true; 
			break; 
	} 

		if($okType){ 
		/** 
		* 0:文件上传成功<br/> 
		* 1：超过了文件大小，在php.ini文件中设置<br/> 
		* 2：超过了文件的大小MAX_FILE_SIZE选项指定的值<br/> 
		* 3：文件只有部分被上传<br/> 
		* 4：没有文件被上传<br/> 
		* 5：上传文件大小为0 
		*/ 
		$error = $upfile["error"];//上传后系统返回的值 
		/*
		echo "================<br/>"; 
		echo "上传文件名称是：".$name."<br/>"; 
		echo "上传文件类型是：".$type."<br/>"; 
		echo "上传文件大小是：".$size."<br/>"; 
		echo "上传后系统返回的值是：".$error."<br/>"; 
		echo "上传文件的临时存放路径是：".$tmp_name."<br/>"; 
		echo "开始移动上传文件<br/>"; 
		*/
		//把上传的临时文件移动到 uploadfiles 目录下面 (iconv解決中文不能存入的問題)
		move_uploaded_file( $tmp_name,iconv('utf-8','gb2312', 'uploadfiles/'.$name )); 
		$destination = "uploadfiles/".$name; 
		
		$data = array('status'=>200,'imagepath'=>$destination,'msg'=>'上传成功！');
		
		echo json_encode($data);
		
		die;
		
		}elseif ($error==1){

			$data = array('status'=>0,'imagepath'=>null,'msg'=>'超过了文件大小，在php.ini文件中设置');
			echo json_encode($data);die;
		
		}elseif ($error==2){ 
			
			$data = array('status'=>0,'imagepath'=>null,'msg'=>'超过了文件的大小MAX_FILE_SIZE选项指定的值');
			echo json_encode($data);die;
		}elseif ($error==3){ 
			$data = array('status'=>0,'imagepath'=>null,'msg'=>'文件只有部分被上传');
			echo json_encode($data);die;
		}elseif ($error==4){ 
		
			$data = array('status'=>0,'imagepath'=>null,'msg'=>'没有文件被上传');
			echo json_encode($data);die;
		}else{ 
			
			$data = array('status'=>0,'imagepath'=>null,'msg'=>'上传文件大小为0');
			echo json_encode($data);die;
		} 
	}else{ 
		$data = array('status'=>0,'imagepath'=>null,'msg'=>'请上传jpg,gif,png等格式的图片！');
		echo json_encode($data);die;
	} 
