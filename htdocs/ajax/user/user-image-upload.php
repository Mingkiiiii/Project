<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

userChk('exit');

$file_chk = is_array($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'][0] : $_FILES['image']['tmp_name'];

if (is_uploaded_file($file_chk)) {
	// 배열일 경우
	if (is_array($_FILES['image']['tmp_name'])) {
		$return_image_arr = [];

		foreach ($_FILES['image']['tmp_name'] as $k => $image) {
			$file_type = $_FILES['image']['type'][$k];

			if ($file_type === "image/jpeg" || $file_type === "image/png" || $file_type === "image/gif") {
				$banner_name = ($mb_r['idx'] . "_" . uniqid() . "_" . (strtotime(date("Y-m-d H:i:s"))) . "_" . $_FILES['image']['name'][$k]);
				$return_image_arr[] = $banner_name;

				$image_file = imageCompress($_FILES['image']['tmp_name'][$k], $_FILES['image']['tmp_name'][$k], 60);
				move_uploaded_file($image_file, "{$_SERVER['DOCUMENT_ROOT']}/uploads/user/{$banner_name}");
			} else die('에러');
		}

		// echo json_encode($return_image_arr);
	} else {
		// 배열이 아닐경우
		$file_type = $_FILES['image']['type'];

		if ($file_type === "image/jpeg" || $file_type === "image/png" || $file_type === "image/gif") {
			$banner_name = ($mb_r['idx'] . "_" . uniqid() . "_" . (strtotime(date("Y-m-d H:i:s"))) . "_" . $_FILES['image']['name']);

			move_uploaded_file($_FILES['image']['tmp_name'], "{$_SERVER['DOCUMENT_ROOT']}/uploads/user/{$banner_name}");

			die($banner_name);
		} else die('에러');
	}
} else die('에러');
