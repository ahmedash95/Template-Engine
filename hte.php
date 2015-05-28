<?php  namespace Ash\Classes;

define('DS',DIRECTORY_SEPARATOR);
/**
* HTML Template Engine
*/
class HTE
{
	private $file;
	private $content;
	private $old_content;

	public function setFile($file)
	{
		if(file_exists($file))
			$this->file = $file;
	}

	public function perpareFile()
	{
		$this->old_content = $this->content = (string) file_get_contents($this->file);
	}

	public function replaceConditions(){
		$this->content = preg_replace('#@(if|while|foreach|for)\((.*?)\)#iU', '<?php $1($2) : ?>', $this->content);
	}
	public function replaceEnds(){
		$this->content = preg_replace('#@end(if|while|foreach|for)#iU', '<?php end$1; ?>', $this->content);
	}
	public function replaceEcho(){
		$this->content = preg_replace('#\{{(.*?)+\}}#iU', '<?php echo $1; ?>', $this->content);
	}
	public function replacePhp(){
		$this->content = preg_replace('#\{php (.*?)+\}#iU', '<?php $1; ?>', $this->content);
	}

	public function compile()
	{
		$this->replaceConditions();
		$this->replaceEnds();
		$this->replaceEcho();
		$this->replacePhp();
	}
	public function runFile(){
		$file = fopen($this->file, 'w');
		$this->compile();
		fwrite($file, $this->content);
		fclose($file);
		include($this->file);
	}
	public function endPrepare()
	{
		$file = fopen($this->file, 'w');
		$this->compile();
		fwrite($file, $this->old_content);
		fclose($file);
	}
	public function run()
	{
		$this->perpareFile();
		$this->runFile();	
		$this->endPrepare();
	}

}