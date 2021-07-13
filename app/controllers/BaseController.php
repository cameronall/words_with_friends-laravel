<?php

use Illuminate\Http\Request;


class BaseController extends Controller {

	public const WILDCARD = '.';
	public $wordArray;
	public $points;
	public $length;

	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout(){
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


	public function sanitize($input){
		## change wildcards to question marks
		
		$input = str_replace('.', $this::WILDCARD, str_replace('?', $this::WILDCARD, str_replace('*', $this::WILDCARD, strtolower($input))));
		
		## strip all input other than alpha, quotes, and wildcards
		$input = preg_replace('/[^a-z'.$this::WILDCARD.'"]/i', '', str_replace("'",'"', $input));

		### cap max allowed wildcards to 3
		if(substr_count($input, $this::WILDCARD) > 3){
			return str_replace($this::WILDCARD, '', $input).'...';
		} else {
			return $input;
		}
	}


	public function showWords(){
		  	
		if(empty($_REQUEST['word'])){ $_REQUEST['word']=''; }
		if(empty($_REQUEST['pre'])){ $_REQUEST['pre']=''; }
		if(empty($_REQUEST['suf'])){ $_REQUEST['suf']=''; }
		if(empty($_REQUEST['sort'])){ $_REQUEST['sort']=''; }
		
		## sanitize all input
		$_REQUEST['word'] = $this->sanitize($_REQUEST['word']);
		$_REQUEST['pre'] = $this->sanitize($_REQUEST['pre']);
		$_REQUEST['suf'] = $this->sanitize($_REQUEST['suf']);
		$_REQUEST['sort'] = $this->sanitize($_REQUEST['sort']);
		
		## Letter point value array
		$point['a']='1';
		$point['b']='4';
		$point['c']='4';
		$point['d']='2';
		$point['e']='1';
		$point['f']='4';
		$point['g']='3';
		$point['h']='3';
		$point['i']='1';
		$point['j']='10';
		$point['k']='5';
		$point['l']='2';
		$point['m']='4';
		$point['n']='2';
		$point['o']='1';
		$point['p']='4';
		$point['q']='10';
		$point['r']='1';
		$point['s']='1';
		$point['t']='1';
		$point['u']='2';
		$point['v']='5';
		$point['w']='4';
		$point['x']='8';
		$point['y']='3';
		$point['z']='10';
		
		$nonWildCards = '';
		$nonWildCardsRegex = '';
		$ltrs = '';
		$letterCountArray = array();
		$mustContain = array();
		
		if(strlen($_REQUEST['word']) > 0){
			## find exact match of letter order
			if(preg_match_all('/"[^"]+"/',$_REQUEST['word'], $matches)){
				$mustContain = $matches['0'];
			}
			
			$word = str_replace('"','',$_REQUEST['word']);
			$lettersArray = str_split(str_replace('"','',$_REQUEST['pre'].$_REQUEST['word'].$_REQUEST['suf']));
			
			foreach($lettersArray as $po=>$pw){
				if(empty($letterCountArray[$pw])){ 
						$letterCountArray[$pw] = 1; 
					} else {
						$letterCountArray[$pw] = $letterCountArray[$pw] + 1;
				}
			}
			$wildcardCount = substr_count($_REQUEST['pre'].$_REQUEST['word'].$_REQUEST['suf'], $this::WILDCARD);
				
			foreach($letterCountArray as $a1=>$a2){
				$ltrs .= "".$a1."|";
				if($a1 != $this::WILDCARD){
					$nonWildCards .= $a1;
					$nonWildCardsRegex .= $a1."{0,".$a2."}|";
				}
			}
			$nonWildCardsRegex = "(".preg_replace('/\|$/', '', $nonWildCardsRegex).")";
			$ltrs = preg_replace('/\|$/', '', $ltrs);
			$ltrs = "(".$ltrs."){1,".(strlen($word)+strlen($_REQUEST['pre'])+strlen($_REQUEST['suf']))."}";	
			
			$wQuery = DB::select("select word from words where word REGEXP '^".$_REQUEST['pre']."".$ltrs."".$_REQUEST['suf']."$'");
			$wordArray['points']=array();
			$wordArray['length']=array();
			if(count($wQuery) > 0){
				foreach($wQuery as $foundWord){
					$i=0;
					$ii=0;
					$wildPts = 0;
					$pts = 0;
					$wrd = $foundWord->word;
					$wordFail = 0;	
					$natWildCnt = $wildcardCount;
					##determine point value if wildcard was used instead of letter
					foreach($letterCountArray as $lett=>$letCnt){
						if($lett != $this::WILDCARD){
							if($letCnt < substr_count($wrd, $lett)){
								if(($natWildCnt - (substr_count($wrd, $lett)-$letCnt)) >= 0){
									$natWildCnt = $natWildCnt - (substr_count($wrd, $lett)-$letCnt);
								} else {
									$wordFail = 1;	
								}
							}
						} else {
							$notWildWord = preg_replace('/['.$nonWildCardsRegex.']/i', '', $wrd);
							if(strlen($notWildWord) > $natWildCnt){
								$wordFail = 1;	
							} else {
								while($ii < strlen($notWildWord)){
									$wildPts = $wildPts + $point[$notWildWord[$ii]];
									++$ii;
								}
								$natWildCnt = $natWildCnt - strlen($notWildWord);
							}
						}
					}
			
					if($wordFail === 0){
						while($i < strlen($wrd)){
							$pts = $pts + $point[$wrd[$i]];
							++$i;
						}
						
						if(count($mustContain) > 0){
							foreach($mustContain as $mVal){							
								if(preg_match('/'.str_replace('"','',$mVal).'/i',$foundWord->word)){
									$wordArray['points'][$foundWord->word] = $pts - $wildPts;
									$wordArray['length'][$foundWord->word] = strlen($foundWord->word);
								} else {
									if(!empty($wordArray['length'][$foundWord->word])){ unset($wordArray['length'][$foundWord->word]); }
									if(!empty($wordArray['points'][$foundWord->word])){ unset($wordArray['points'][$foundWord->word]); }
								}
							}
						} else {
							$wordArray['points'][$foundWord->word] = $pts - $wildPts;
							$wordArray['length'][$foundWord->word] = strlen($foundWord->word);	
						}
					}
				}
			
				if($_REQUEST['sort']==''){
					krsort($wordArray['points']);	
					natcasesort($wordArray['points']);
					$wordArray['points'] = array_reverse($wordArray['points']);
				} elseif($_REQUEST['sort']==='name'){
					krsort($wordArray['points']);
					$wordArray['points'] = array_reverse($wordArray['points']);
				} elseif($_REQUEST['sort']==='length'){
					natcasesort($wordArray['length']);
					$wordArray['length'] = array_reverse($wordArray['length']);
				}
				
			}
		}
		
		if(empty($wordArray)){
			$wordArray['points']['words'] = '15';
			$wordArray['points']['with'] = '14';
			$wordArray['points']['friends'] = '13';
			$wordArray['points']['help'] = '12';
			$wordArray['points']['cheat'] = '11';
			$wordArray['points']['for'] = '10';
			$wordArray['points']['iphone'] = '9';
			$wordArray['points']['and'] = '8';
			$wordArray['points']['android'] = '7';
			$wordArray['points']['dictionary'] = '6';
			$wordArray['points']['scrabble'] = '5';
			$wordArray['length']=$wordArray['points'];
		}
		
		return View::make('words', $wordArray);
	}

}
