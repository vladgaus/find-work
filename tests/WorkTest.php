<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Work;

class WorkTest extends TestCase
{
	
	public function getBoard()
	{
		return [
			'"Company A" requires an apartment or house, and property insurance.',
			'"Company B" requires 5 door car or 4 door car, and a driver\'s license and car insurance.',
			'"Company C" requires a social security number and a work permit.',
			'"Company D" requires an apartment or a flat or a house.',
			'"Company E" requires a driver\'s license and a 2 door car or a 3 door car or a 4 door car or a 5 door car.',
			'"Company F" requires a scooter or a bike, or a motorcycle and a driver\'s license and motorcycle insurance.',
			'"Company G" requires a massage qualification certificate and a liability insurance.',
			'"Company H" requires a storage place or a garage.',
			'"Company J" doesn\'t require anything, you can come and start working immediately.',
			'"Company K" requires a PayPal account.',
		];
	}
	
	public function getCompaniesByMyConditions()
	{
		return [
			[
				'CONDITIONS' => [
					'bike',
					'driver\'s license',
				],
				'COMPANIES' => [
					'GOOD' => [
						'"Company J"',
					],
					'BAD' => [
						'"Company A"',
						'"Company B"',
						'"Company C"',
						'"Company D"',
						'"Company E"',
						'"Company F"',
						'"Company G"',
						'"Company H"',
						'"Company K"',
					],
				],
			],
			[
				'CONDITIONS' => [
					'car',
					'driver\'s license',
					'insurance',
				],
				'COMPANIES' => [
					'GOOD' => [
						'"Company B"',
						'"Company E"',
						'"Company J"',
					],
					'BAD' => [
						'"Company A"',
						'"Company C"',
						'"Company D"',
						'"Company F"',
						'"Company G"',
						'"Company H"',
						'"Company K"',
					],
				],
			],
			[
				'CONDITIONS' => [
					'garage',
					'car',
					'PayPal account',
					'apartment'
				],
				'COMPANIES' => [
					'GOOD' => [
						'"Company D"',
						'"Company H"',
						'"Company J"',
						'"Company K"',
					],
					'BAD' => [
						'"Company A"',
						'"Company B"',
						'"Company C"',
						'"Company E"',
						'"Company F"',
						'"Company G"',
					],
				],
			],
			[
				'CONDITIONS' => [
					'Chine language',
				],
				'COMPANIES' => [
					'GOOD' => [
						'"Company J"',
					],
					'BAD' => [
						'"Company A"',
						'"Company B"',
						'"Company C"',
						'"Company D"',
						'"Company E"',
						'"Company F"',
						'"Company G"',
						'"Company H"',
						'"Company K"',
					],
				],
			],
		];
	}
	
	public function testFind()
	{
		
		$board = $this->getBoard();
		$checkList = $this->getCompaniesByMyConditions();
		
		foreach ($checkList as $checkPoint) {
			$work = new Work($board, $checkPoint['CONDITIONS']);
			$work->find();
			$companies = $work->get();
			$this->assertEquals($checkPoint['COMPANIES']['GOOD'], $companies['GOOD'], "Wrong list of companies where i can work");
			$this->assertEquals($checkPoint['COMPANIES']['BAD'], $companies['BAD'], "Wrong list of companies where i can't work");
		}
		
	}
}