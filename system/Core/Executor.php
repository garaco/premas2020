<?php

class Executor {
	public static function doit($sql){
		$con = DB::getCon();
		return $con->query($sql);
	}
}
