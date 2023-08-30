<?php

class framework{

	public function view($viewName)
	{
		if (file_exists("../application/views/".$viewName.".php")) 
		{
			require_once "../application/views/".$viewName.".php";
		}
		else
		{
			echo "<div style='margin:0;padding:10px;background-color:silver;'>Sorry ".$viewName.".php Not Found.....!</div>";
		}
	}

	public function model($modelName)
	{
		if (file_exists("../application/models/".$modelName.".php")) 
		{
			require_once "../application/models/".$modelName.".php";
			return new $modelName;
		}
		else
		{
			echo "<div style='margin:0;padding:10px;background-color:silver;'>Sorry ".$modelName.".php Not Found.....!</div>";
		}
	}

	public function helper($helperName)
	{
		if (file_exists("../system/helpers/".$helperName.".php")) 
		{
			require_once "../system/helpers/".$helperName.".php";
		}
		else
		{
			echo "<div style='margin:0;padding:10px;background-color:silver;'>Sorry Helper ".$helperName.".php File Not Found.....!</div>";
		}
	}

	public function redirect($path=null)
	{
		if(!empty($path))
		{
			header("location:" . BASEURL . "/".$path);
		}
		else
		{
			header("location:" . BASEURL);
		}
    }
    
}

?>