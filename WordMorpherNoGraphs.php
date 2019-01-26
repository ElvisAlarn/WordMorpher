<?php

/*
 
$start = 'муха';
$end = 'слон';
$words  = array('слон','муха','маха','мана','кана','лето','хлеб','цветы','вода','канн','кран','каон','стакан','клон');

для теста оставил, можно закоментировать нижнюю цепочку и раскоментировать эту для поиска новых слов 

*/

$start = 'лужа';
$end = 'море';
$words  = array('лужа', 'ложа', 'кора','цвет','меха','труха','кожа','цветы','вода','гора','кран','горе','сора','ножи', 'море');

function encode($string){
	$arrRuEnc = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','э','ю','я');
	$arrEnEnc = array('a','b','v','g','d','e','1','2','z','i','3','k','l','m','n','o','p','r','s','t','u','f','h','c','4','5','6','7','8','9','y','q');
	$string = preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
	foreach($string as $word){
		foreach($arrRuEnc as $k => $num){
			if($word == $num){
				$code .= $arrEnEnc[$k];
			}
		}
	}
	return $code;
}

$str = '';

function search($start,$words,$end,$str){
	if(strlen($start) != strlen($end)){
		print "Слова должны быть одинаковой длины, иначе алгоритм не сработает!";
		die();
	}
	foreach($words as $i => $word){
		$lev = levenshtein(encode($start),encode($word));
		if($lev <= 1){
			$start = $word;
			unset($words[$i]);
			if($end != $start){
				$str .= $start.' => ';
				search($start,$words,$end,$str);
			}else{
				$flag = 1;
				$str .= $start;
				finish($flag,$str);
				exit;
			}
		}	
	}
	
	if(!isset($flag)){
		$flag = 0;
		finish($flag);
		exit;
	}
	
}

function finish($flag,$str){
	if($flag == 1){
		$FinalWordsChain = explode('=>',$str);
		$firstWordInChain = $FinalWordsChain[0];
		$lastWordInChain = end($FinalWordsChain);
		print "Найдена цепочка слов от слова {$firstWordInChain} до слова {$lastWordInChain}:<br><br>";
		print $str;
	}else{
		print "Невозможно построить цепочку слов";
	}
}

search($start,$words,$end,$str);

?>