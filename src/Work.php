<?php
declare(strict_types=1);

namespace App;

/**
 * Class find companies from the board and return companies filtered by my conditions
 * Algorithm is O(n), where n - count of companies in the board
 */


class Work
{
	/**
	 * The board - list of companies
	 *
	 * @var array
	 */
	public $board = [];
	
	/**
	 * It's my conditions. What i have. Example: bike, garage etc
	 */
	public $myConditions = [];
	
	/**
	 * Companies for work
	 */
	public $companies = [];
	
	/**
	 * Constructor
	 *
	 * @param array $board
	 * @param array $myConditions
	 */
	public function __construct(array $board, array $myConditions)
	{
		$this->board = $board;
		$this->myConditions = $myConditions;
	}
	
	/**
	 * This method filter companies by their requires and my conditions
	 *
	 * @param array $requires - require of company
	 * @param string - name of company
	 * @return void
	 */
	protected function filter($requires, $name)
	{
		// here we prepare params for pattern from my conditions
		$myCond = implode('|', $this->myConditions);
		
		// try to find all keys from array $requires where exists my conditions
		$find = preg_grep("/(" . $myCond . ")/", $requires);
		
		// compare arrays
		// need have each of requirement (because we used AND separator)
		// it's mean all keys from company requires must equal all keys from array which preg all our conditions
		if (array_keys($requires) == array_keys($find)) {
			$this->companies[] = trim($name);
		}

	}
	
	/**
	 * Find work by all companies from the board
	 * Use my conditions like filter
	 *
	 * @return void
	 */
	public function find()
	{
		foreach ($this->board as $company) {
			
			// if company doesn't require something - it's mean i can work in it
			// so let's check it
			if (strpos($company, 'doesn\'t require') !== false) {
				list($companyName, $requires) = preg_split('/(doesn\'t require)\s(\S*)/', $company);
				$this->companies[] = trim($companyName);
			} else {
				list($companyName, $requires) = preg_split('/(requires)\s(\S*)/', $company);
				
				// separate each requirement by AND
				$requiresAnd = preg_split('/(and)\s(\S*)/', $requires);
				
				// filter
				$this->filter($requiresAnd, $companyName);
			}
			
		}
	}
	
	/**
	 * Get list of filtered companies
	 *
	 * @return array
	 */
	public function get(): array
	{
		return $this->companies;
	}
}