<?php
class __paging__ {

	public $ps, $pb, $np;

	public function init($total) {
		$this->ps = (empty($this->ps)) ? 10 : $this->ps;	// 한페이지내 리스트 갯수
		$this->pb = (empty($this->pb)) ? 5 : $this->pb;		// 페이지 블록
		$this->np = (empty($this->np)) ? 1 : $this->np;		// 현재 페이지
		$PG = new stdClass();
		$PG->size = $this->ps;
		$PG->now = $this->np;
		$PG->all = $total;
		$PG->block = ceil($PG->all / $this->ps);
		$PG->nb = ceil($this->np / $this->pb);
		$PG->tmp = ($PG->nb * $this->pb) - ($this->pb-1);
		$PG->start = ($PG->tmp <= 1) ? 1 : $PG->tmp;
		$PG->tmp = ($PG->nb * $this->pb);
		$PG->end = ($PG->all <= $PG->tmp) ? $PG->all : $PG->tmp;
		$PG->first = ($PG->now - 1) * $this->ps;
		$PG->first_num = $PG->all - ($PG->now - 1) * $PG->size;
		return $PG;
	}

	public function paging($object, $ret = false) {
		if($object->start >= $object->now) { $start['class'] = 'disabled'; $start['link'] = 'javascript:;'; } else { $start['class'] = ''; $start['link'] = '?np='.$object->start; }
		if($object->block <= $object->now) { $end['class'] = 'disabled'; $end['link'] = 'javascript:;'; } else { $end['class'] = ''; $end['link'] = '?np='.$object->block; }
		$return = '
	<div style="text-align:center;">
		<ul class="pagination">
			<li class="'.$start['class'].'"><a href="'.$start['link'].'"><span class="glyphicon ti-angle-double-left"></span></a></li>
		';
		for($i = $object->start ; $i <= $object->block ; $i++) { $return .= '<li class="'.(($i == $object->now)?'active':'').'"><a href="?np='.$i.'">'.$i.'</a></li>'; }
		$return .= '
			<li class="'.$end['class'].'"><a href="'.$end['link'].'"><span class="glyphicon ti-angle-double-right"></span></a></li>
		</ul>
	</div>
		';
		if($ret == false) { echo $return; } else { return $return; }
	}

}

if(!isset($paging)) {
	$paging = new __paging__;
}
