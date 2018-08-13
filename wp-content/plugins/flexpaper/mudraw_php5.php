<?php
/**
* █▒▓▒░ The FlexPaper Project
*
* Copyright (c) 2009 - 2011 Devaldi Ltd
*
* When purchasing a commercial license, its terms substitute this license.
* Please see http://flexpaper.devaldi.com/ for further details.
*
*/

class mudrawpdf
{
	private $configManager = null;

	/**
	* Constructor
	*/
	function __construct()
	{
		if(	PHP_OS == "WIN32" || PHP_OS == "WINNT"	){
            $this->command = "mudraw.exe -r120 -m -o \"{path.swf}{pdffile}_%d.png\" \"{path.pdf}{pdffile}\" {page}";
        }else{
            $this->command = "mudraw -r120 -m -o \"{path.swf}{pdffile}_%d.png\" \"{path.pdf}{pdffile}\" {page}";
        }
	}

	/**
	* Destructor
	*/
	function __destruct() {

    }

	/**
	* Method:muDraw
	*/
	public function draw($path_to_mudraw,$pdfdoc,$swfdoc,$page,$subfolder)
	{
		$output=array();
        $command = $path_to_mudraw . $this->command;
        $command = str_replace("{path.pdf}",$this->pdf_dir . $subfolder,$command);
        $command = str_replace("{path.swf}",$this->swf_dir . $subfolder,$command);
        $command = str_replace("{pdffile}",$pdfdoc,$command);
        $command = str_replace("{page}",$page,$command);

		try {
    		$return_var=0;
            exec($command,$output,$return_var);
            if($return_var==1 || $return_var==0 || (strstr(PHP_OS, "WIN") && $return_var==1)){
                return "[OK]";
            }else{
                return "[Error converting PDF using MuDraw, please check your configuration]";
            }
		} catch (Exception $ex) {
			return $ex;
		}
	}
}
?>