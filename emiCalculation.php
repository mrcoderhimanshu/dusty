<?php

Class EmiCalculation{

	
	/*
	* Principal amount we are giving
	* 
	* @access : private
	* @dataType : double
	*/
	private $principal  = 0;
	
	/*
	* tenure is the time for which we are giving the loan
	* 
	* @access : private
	* @dataType : int
	*/
	private $tenure 	= 0;
	
	/*
	* rate is the rate of intrest we are charging and it must be yearly
	* 
	* @access : private
	* @dataType : int
	*/
	private $rate 		= 0;
	
	private $tenureType = 0;
	
	private $emiMode    = 0;
	
	private $loanType   = 1;
	
	
	private $tenureScale = array('DAILY', 'WEEKLY', 'HALF_MONTH', 'HALF_MONTH', 'MONTHLY', 'QUATERLY', 'HALF_YEARLY', 'YEARLY');
	
	
	public function CalEmi($principal, $tenure, $tenureType, $rate, $emiMode, $loanType = 1){
		
		$this->principal = $principal;
		$this->tenure    = $tenure;
		$this->tenureType= $this->tenureScale[$tenureType];
		$this->emiMode   = $this->tenureScale[$emiMode];
		$this->loanType  = $loanType;
		$this->setPeriodInterest();
		
		
	}
	
	
}
?>