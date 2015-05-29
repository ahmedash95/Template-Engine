<?php  namespace Ash\Classes;

define('DS',DIRECTORY_SEPARATOR);
/**
* HTML Template Engine
* it's a very simple Template Engine - look like laravel Template :D - 
* @author Ahmed Ashraf
* @version 0.0.1
* GitHub  : github.com/ahmedash95
* Twitter : @ahmedash95
* Email   : ahmed29329@gmail.com
*/

class HTE
{	
	/** 
	* The Template PHP File
	* @var String
	*/
	private $file;
	/**
	* The File entire contnet
	* @var string
	*/
	private $content;
	/** 
	* The new file after compiling 
	* @var string
	*/	
	private $inhertance_file;
	/** 
	* The files main directory 
	* @var string
	*/	
	private $inhertance_dir = "storage";

	/**
	* Set the file for compiling
	* @param string $file
	* @return void
	*/
	public function setFile($file)
	{
		if(file_exists($file))
			$this->file = $file;
	}

	/**
	* Set the directory for saving new files after Compiling
	* @param string $dir
	* @return void
	*/
	public function setDir($dir)
	{
		$this->inhertance_dir = $dir;
	}

	/**
	* Get the file content  
	* @param none
	* @return void
	*/
	public function perpareFile()
	{
		$this->content = (string) file_get_contents($this->file);
	}

	/**
	* In this method we will replace the template conditions
	* @ If|While|Foreach|For  
	* @return void
	*/
	public function replaceConditions(){
		$pattern = '#@(if|while|foreach|for)\((.*?)\)#iU';
		$replace = '<?php $1($2) : ?>';
		$this->compilerFunction($pattern,$replace);
	}

	/**
	* In this method we will replace the template end conditions
	* @end If|While|Foreach|For  
	* @return void
	*/
	public function replaceEnds(){
		$pattern = '#@end(if|while|foreach|for)#iU';
		$replace = '<?php end$1; ?>';
		$this->compilerFunction($pattern,$replace);
	}

	/**
	* In this method we will replace the template echos
	* {{ any }}  
	* @return void
	*/
	public function replaceEcho(){
		$pattern = '#\{{(.*?)+\}}#iU';
		$replace = '<?php echo $1; ?>';
		$this->compilerFunction($pattern,$replace);
	}
	/**
	* In this method we will replace the template php tag
	* @php( -php code- )
	* @return void
	*/
	public function replacePhp(){
		$pattern = '#\@php\((.*?)+\)#iU';
		$replace = '<?php $1; ?>';
		$this->compilerFunction($pattern,$replace);
	}

	/**
	* In this method we will replace the template includes
	* @ Include|Include_once|require|require_once 
	* @return void
	*/
	public function replaceIncludes()
	{
		$pattern = '#\@(include|include_once|require|require_once)\((.*?)+\)#iU';
		$replace = '<?php $1($2); ?>';
		$this->compilerFunction($pattern,$replace);	
	}

	/**
	* In this method we will replace the template dump
	* @dump( -any- ) replace with var_dump( -any- )
	* @return void
	*/
	public function replaceDump()
	{
		$pattern = '#\@dump\((.*?)+\)#iU';
		$replace = '<?php var_dump($1); ?>';
		$this->compilerFunction($pattern,$replace);	
	}

	/**
	* In this method we will replace the template print
	* @print_r( -any- ) replace with print_r( -any- )
	* @return void
	*/
	public function replacePrint()
	{
		$pattern = '#\@print_r\((.*?)+\)#iU';
		$replace = '<?php print_r($1); ?>';
		$this->compilerFunction($pattern,$replace);	
	}

	/**
	* In this method we will replace the template pre
	* @pre( -any- ) replace with <pre> var_dump( -any- ) </pre>
	* @return void
	*/
	public function replacePre()
	{
		$pattern = '#\@pre\((.*?)+\)#iU';
		$replace = '<?php echo "<pre>"; var_dump($1); echo "</pre>"; ?>';
		$this->compilerFunction($pattern,$replace);	
	}


	/**
	* In this method we will replace all template 
	* functions using Regular Experessions
	* @param $pattern - Regular Expression Pattern
	* @param $replace - String
	* @return void
	*/
	public function compilerFunction($pattern,$replace)
	{
		$this->content = preg_replace($pattern, $replace, $this->content);
	}


	/**
	* In this method we will call all the template replacer functions
	* @return void
	*/
	public function compile()
	{
		$this->replaceConditions();
		$this->replaceEnds();
		$this->replaceEcho();
		$this->replacePhp();
		$this->replaceIncludes();
		$this->replaceDump();
		$this->replacePrint();
		$this->replacePre();
	}

	/**
	* In this method we will Make a new instance file to store the new code
	* after the compilation  
	* @return void
	*/
	public function makeFile()
	{
		if(!is_dir($this->inhertance_dir))
			mkdir($this->inhertance_dir);

		if(!is_writable($this->inhertance_dir))
			@chmod($this->inhertance_dir,'0777');
		
		$this->inhertance_file = $this->inhertance_dir.DS.'HTE-'.md5($this->file.date('T:M:S')).'.php';		
	}

	/**
	* In this method we will create a new file and store the new code 
	* and include the file
	* @return void
	*/
	public function runFile(){
		$file = fopen($this->inhertance_file, 'w');
		$this->compile();
		fwrite($file, $this->content);
		fclose($file);
		include($this->inhertance_file);
	}

	/**
	* Prepare the File 
	* then Make The new File
	* finally Run The New File
	* @return void
	*/
	public function run()
	{
		$this->perpareFile();
		$this->makeFile();
		$this->runFile();	
	}

}