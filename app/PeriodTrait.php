<?php

namespace App;
use Illuminate\Http\Request;
trait PeriodTrait {

	public function getShowYear(Request $request)
		
		{
			$showyear = $request->get('year');
			if(isset( $showyear)){
				$request->session()->put('showyear',$showyear);
				$this->showyear = $request->session()->get('showyear');
				
			}elseif ($request->session()->has('showyear')){
			
				$this->showyear = $request->session()->get('showyear');
			}else{
				$this->showyear = date('Y');
				$request->session()->put('showyear',$this->showyear);
			}

		}
}