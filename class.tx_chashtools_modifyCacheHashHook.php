<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Oliver Hader <oliver@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once(t3lib_extMgm::extPath('chashtools') . 'class.tx_chashtools.php');

/**
 * Hook to modify the cHash.
 *
 * @author Oliver Hader <oliver@typo3.org>
 */
class tx_chashtools_modifyCacheHashHook {
	/**
	 * @var array
	 */
	protected $excludeArguments;

	/**
	 * Processes the hook.
	 *
	 * @param array &$parameters
	 * @return void
	 * @see t3lib_div::cHashParams
	 */
	public function process(array $parameters) {
		foreach ($this->getExcludeArguments() as $excludeArgument) {
			$excludeParts = explode('=', $excludeArgument, 2);
			$arguments = &$parameters['pA'];

				// If the argument is a real value:
			if (isset($arguments[$excludeParts[0]])) {
				if (!isset($excludeParts[1]) || (string)$arguments[$excludeParts[0]] === $excludeParts[1]) {
					unset($arguments[$excludeParts[0]]);
				}
				// If the argument is set to NULL:
			} elseif ($excludeParts[1] === '') {
				unset($arguments[$excludeParts[0]]);
			}
		}
	}

	/**
	 * Gets the exclude arguments.
	 *
	 * @return array
	 */
	public function getExcludeArguments() {
		if (!isset($this->excludeArguments)) {
			$this->setExcludeArguments(
				tx_chashtools::getExcludeArguments()
			);
		}

		return $this->excludeArguments;
	}

	/**
	 * Sets the exclude arguments.
	 *
	 * @param array $excludeArguments
	 * @return void
	 */
	public function setExcludeArguments(array $excludeArguments) {
		$this->excludeArguments = $excludeArguments;
	}
}
