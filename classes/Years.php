<?
class years {
	
		public function years ($num) {

			$a = mb_strlen ($num);
			$num = $num[$a-1];

		 	if ($num >= 5 || $num == 0) {
		    	return $year = 'лет';
		    }elseif ($num > 1 && $num < 5) {
		    	return $year = 'года';
		    }else{
		    	return $year = 'год';
		    }
		}

		 public function count_views ($num) {

		 	$a = mb_strlen ($num);
			$num = $num[$a-1];
		 	if ($num >= 5 || $num == 0) {
		    	return $year = 'просмотров';
		    }elseif ($num > 1 && $num < 5) {
		    	return $year = 'просмотра';
		    }else{
		    	return $year = 'просмотр';
		    }
		}

		 public function count_likes ($num) {

		 	$a = mb_strlen ($num);
			$num = $num[$a-1];
		 	if ($num >= 5 || $num == 0) {
		    	return $year = 'лайков';
		    }elseif ($num > 1 && $num < 5) {
		    	return $year = 'лайка';
		    }else{
		    	return $year = 'лайк';
		    }
		}

}