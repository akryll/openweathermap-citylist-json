<?php
/**
* 
*/
class OWM
{
	
	public function __construct($type)
	{	
		echo "OpenWeatherMap.org CityList JSON Generator v0.1a by Akryll\n";
		$this->type = $type;
		echo "Prepating file to convert...\n";
		$tmp = file_get_contents('city_list.txt');
		$save = str_replace("\t", ';;', $tmp);
		file_put_contents('temp.txt', $save);
		echo "Done...\n";
		$this->getData();

	}
	public function  getData(){
		echo "Start convert.\n";
		$file = [];
		$c = file('temp.txt');
		unset($c[0]);
		foreach ($c as $key => $value) {
			$ca = explode(';;', $value);
			$row = new stdClass();
			$row->id = $this->utf8ize(rtrim($ca[0]));
			$row->name = $this->utf8ize(rtrim($ca[1]));
			$row->lat = $this->utf8ize(rtrim($ca[2]));
			$row->lon = $this->utf8ize(rtrim($ca[3]));
			$row->cc = $this->utf8ize(rtrim($ca[4]));
			if($this->type == 'full'){
				$file[] = $row;
			}
			elseif ($this->type == 'bycc') {
				$file[$row->cc][] = $row;
			}
			elseif ($this->type != 'full' && $this->type != 'bycc') {
				if($row->cc == $this->type){
					$file[$this->type][] = $row;
				}
			}
		}

		if($this->type == 'full'){
			file_put_contents('output.json', json_encode($file));
			echo "Full list saved to output.json\n";
		}
		elseif ($this->type == 'bycc') {
			foreach ($file as $k => $v) {
				echo "Saving $k counrty...\n";
				file_put_contents('byCC/'. $k .'.json', json_encode($v));
			}
			echo "All country saved!\n";
		}
		elseif ($this->type != 'full' && $this->type != 'bycc') {
			foreach ($file as $k => $v) {
				echo "Saving $k counrty...\n";
				file_put_contents('byCC/'. $k .'.json', json_encode($v));
			}
			echo "$this->type saved...\n";
		}
	}
	private function utf8ize($d) {
		if (is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = utf8ize($v);
			}
		} else if (is_string ($d)) {
			return utf8_encode($d);
		}

		return $d;
	}
}
$run = new OWM($argv[1]);
?>