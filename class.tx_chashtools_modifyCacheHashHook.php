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

/**
 * Hook to modify the cHash.
 *
 * @author Oliver Hader <oliver@typo3.org>
 */
class tx_chashtools_modifyCacheHashHook {
	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 * Processes the hook.
	 *
	 * @param array &$parameters
	 * @return void
	 * @see t3lib_div::cHashParams
	 */
	public function process(array $parameters) {
		$excludeArguments = t3lib_div::trimExplode(',', $this->getExcludeList(), TRUE);

		foreach ($excludeArguments as $excludeArgument) {
			$excludeParts = explode('=', $excludeArgument, 2);

			if (isset($parameters['pA'][$excludeParts[0]]) && (!isset($excludeParts[1]) || $parameters['pA'][$excludeParts[0]] == $excludeParts[1])) {
				unset($parameters['pA'][$excludeParts[0]]);
			}
		}
	}

	/**
	 * Gets the extension configuration.
	 *
	 * @return array
	 */
	protected function getConfiguration() {
		if (!isset($this->configuration)) {
			$this->configuration = array();

			if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['chashtools'])) {
				$this->configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['chashtools']);
			}
		}

		return $this->configuration;
	}

	/**
	 * Gets the exclude list from the extension configuration.
	 *
	 * @return string
	 */
	protected function getExcludeList() {
		$excludeList = '';

		$configuration = $this->getConfiguration();
		if (isset($configuration['excludeList'])) {
			$excludeList = $configuration['excludeList'];
		}

		return $excludeList;
	}
}
